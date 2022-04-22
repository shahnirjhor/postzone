<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Revenue;
use App\Models\Category;
use App\Traits\DateTime;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 * @category Controller
 */
class DashboardController extends Controller
{
    use DateTime;

    public $today;

    public $company;

    public $financial_start;

    public $income_donut = ['colors' => [], 'labels' => [], 'values' => []];

    public $expense_donut = ['colors' => [], 'labels' => [], 'values' => []];

    public function index()
    {
        $company = Company::findOrFail(Session::get('company_id'));
        $company->setSettings();

        $this->company = $company;
        $this->today = Carbon::today();

        $this->financial_start = $financial_start = $this->getFinancialStart()->format('Y-m-d');

        // check and assign year start
        if (($year_start = $this->today->startOfYear()->format('Y-m-d')) !== $this->financial_start) {
            $year_start = $this->financial_start;
        }

        $start = Carbon::parse(request('start', $year_start));
        $end = Carbon::parse(request('end', Carbon::parse($year_start)->addYear(1)->subDays(1)->format('Y-m-d')));
        $period = request('period', 'month');
        $range = request('range', 'custom');

        $start_month = $start->month;
        $end_month = $end->month;

        $s = clone $start;

        if ($range == 'last_12_months') {
            $end_month   = 12;
            $start_month = 0;
        } elseif ($range == 'custom') {
            $end_month   = $end->diffInMonths($start);
            $start_month = 0;
        }

        for ($j = $end_month; $j >= $start_month; $j--) {
            $labels[$end_month - $j] = $s->format('M Y');

            if ($period == 'month') {
                $s->addMonth();
            } else {
                $s->addMonths(3);
                $j -= 2;
            }
        }

        $cincome = $this->calculateCashFlowTotals('income', $start, $end, $period);
        $cexpense = $this->calculateCashFlowTotals('expense', $start, $end, $period);
        $cprofit = $this->calculateCashFlowProfit($cincome, $cexpense);

        // dd($cprofit);
        $formattedCprofit = array_map(function($num){return number_format($num,2);}, $cprofit);

        $myMonth = json_encode(array_values($labels));
        $myIncomesGraph = json_encode(array_values($cincome));
        $myExpenseGraph = json_encode(array_values($cexpense));
        $myProfitsGraph = json_encode(array_values($formattedCprofit));


        // Monthly
        $labels = array();

        list($total_incomes, $total_expenses, $total_profit) = $this->getTotals();

        $dIncomesDataName = array();
        $dIncomesDataValue = array();
        $dIncomesDataColor = array();

        if (array_sum($this->income_donut['values']) == 0) {
            foreach ($this->income_donut['values'] as $key => $value) {
                $this->income_donut['values'][$key] = 1;
            }
        }

        $dIncomesDataColor = $dIncomesDataName = [];
        $dIncomesDataValue = collect($this->income_donut['values'])->sort()->reverse()->take(6)->all();
        foreach ($dIncomesDataValue as $id => $val) {
            $dIncomesDataColor[$id] = $this->income_donut['colors'][$id];
            $dIncomesDataName[$id] = $this->income_donut['labels'][$id];
        }

        $dIncomesDataName = json_encode(array_values($dIncomesDataName));
        $dIncomesDataValue = json_encode(array_values($dIncomesDataValue));
        $dIncomesDataColor = json_encode(array_values($dIncomesDataColor));

        $dExpenseDataName = array();
        $dExpenseDataValue = array();
        $dExpenseDataColor = array();

        if (array_sum($this->expense_donut['values']) == 0) {
            foreach ($this->expense_donut['values'] as $key => $value) {
                $this->expense_donut['values'][$key] = 1;
            }
        }

        $dExpenseDataColor = $dExpenseDataName = [];
        $dExpenseDataValue = collect($this->expense_donut['values'])->sort()->reverse()->take(6)->all();
        foreach ($dExpenseDataValue as $id => $val) {
            $dExpenseDataColor[$id] = $this->expense_donut['colors'][$id];
            $dExpenseDataName[$id] = $this->expense_donut['labels'][$id];
        }

        $dExpenseDataName = json_encode(array_values($dExpenseDataName));
        $dExpenseDataValue = json_encode(array_values($dExpenseDataValue));
        $dExpenseDataColor = json_encode(array_values($dExpenseDataColor));


        $latest_incomes = $this->getLatestIncomes();
        $latest_expenses = $this->getLatestExpenses();

        return view('dashboard', compact(
            'company',
            'myMonth',
            'myIncomesGraph',
            'myExpenseGraph',
            'myProfitsGraph',
            'dIncomesDataName',
            'dIncomesDataValue',
            'dIncomesDataColor',
            'dExpenseDataName',
            'dExpenseDataValue',
            'dExpenseDataColor',
            'total_incomes',
            'total_expenses',
            'total_profit',
            'latest_incomes',
            'latest_expenses',
            'financial_start'
        ));
    }

    private function getLatestIncomes()
    {
        $invoices = collect(Invoice::orderBy('invoiced_at', 'desc')->accrued()->take(10)->get())->each(function ($item) {
            $item->paid_at = $item->invoiced_at;
        });

        $revenues = collect(Revenue::orderBy('paid_at', 'desc')->isNotTransfer()->take(10)->get());

        $latest = $revenues->merge($invoices)->take(5)->sortByDesc('paid_at');

        return $latest;
    }

    private function getLatestExpenses()
    {
        $bills = collect(Bill::orderBy('billed_at', 'desc')->accrued()->take(10)->get())->each(function ($item) {
            $item->paid_at = $item->billed_at;
        });

        $payments = collect(Payment::orderBy('paid_at', 'desc')->isNotTransfer()->take(10)->get());

        $latest = $payments->merge($bills)->take(5)->sortByDesc('paid_at');

        return $latest;
    }

    private function getTotals()
    {
        list($incomes_amount, $open_invoice, $overdue_invoice, $expenses_amount, $open_bill, $overdue_bill) = $this->calculateAmounts();

        $incomes_progress = 100;
        if (!empty($open_invoice) && !empty($overdue_invoice)) {
            $incomes_progress = (int) ($open_invoice * 100) / ($open_invoice + $overdue_invoice);
        }
        // Totals
        $total_incomes = array(
            'total'             => $incomes_amount,
            'open_invoice'      => money($open_invoice, $this->company->default_currency, true),
            'overdue_invoice'   => money($overdue_invoice, $this->company->default_currency, true),
            'progress'          => $incomes_progress
        );

        $expenses_progress = 100;
        if (!empty($open_bill) && !empty($overdue_bill)) {
            $expenses_progress = (int) ($open_bill * 100) / ($open_bill + $overdue_bill);
        }
        $total_expenses = array(
            'total'         => $expenses_amount,
            'open_bill'     => money($open_bill, $this->company->default_currency, true),
            'overdue_bill'  => money($overdue_bill, $this->company->default_currency, true),
            'progress'      => $expenses_progress
        );

        $amount_profit = $incomes_amount - $expenses_amount;
        $open_profit = $open_invoice - $open_bill;
        $overdue_profit = $overdue_invoice - $overdue_bill;

        $total_progress = 100;

        if (!empty($open_profit) && !empty($overdue_profit)) {
            $total_progress = (int) ($open_profit * 100) / ($open_profit + $overdue_profit);
        }

        $total_profit = array(
            'total'         => $amount_profit,
            'open'          => money($open_profit, $this->company->default_currency, true),
            'overdue'       => money($overdue_profit, $this->company->default_currency, true),
            'progress'      => $total_progress
        );

        return array($total_incomes, $total_expenses, $total_profit);
    }

    private function calculateAmounts()
    {
        $incomes_amount = $open_invoice = $overdue_invoice = 0;
        $expenses_amount = $open_bill = $overdue_bill = 0;

        $categories = Category::with(['bills', 'invoices', 'payments', 'revenues'])->orWhere('type', 'income')->orWhere('type', 'expense')->where('enabled', 1)->get();

        foreach ($categories as $category) {
            switch ($category->type) {
                case 'income':
                    $amount = 0;
                    // Revenues
                    foreach ($category->revenues as $revenue) {
                        $amount += $revenue->getConvertedAmount();
                    }
                    $incomes_amount += $amount;

                    // Invoices
                    $invoices = $category->invoices()->accrued()->get();
                    foreach ($invoices as $invoice) {
                        list($paid, $open, $overdue) = $this->calculateInvoiceBillTotals($invoice, 'invoice');

                        $incomes_amount += $paid;
                        $open_invoice += $open;
                        $overdue_invoice += $overdue;

                        $amount += $paid;
                    }

                    $this->addToIncomeDonut($category->color, $amount, $category->name);

                    break;

                case 'expense':
                    $amount = 0;
                    // Payments
                    foreach ($category->payments as $payment) {
                        $amount += $payment->getConvertedAmount();
                    }

                    $expenses_amount += $amount;

                    // Bills
                    $bills = $category->bills()->accrued()->get();
                    foreach ($bills as $bill) {
                        list($paid, $open, $overdue) = $this->calculateInvoiceBillTotals($bill, 'bill');

                        $expenses_amount += $paid;
                        $open_bill += $open;
                        $overdue_bill += $overdue;

                        $amount += $paid;
                    }

                    $this->addToExpenseDonut($category->color, $amount, $category->name);

                    break;
            }
        }
        return array($incomes_amount, $open_invoice, $overdue_invoice, $expenses_amount, $open_bill, $overdue_bill);
    }

    private function calculateInvoiceBillTotals($item, $type)
    {
        $paid = $open = $overdue = 0;

        $today = $this->today->toDateString();

        $paid += $item->getConvertedAmount();

        $code_field = $type . '_status_code';

        if ($item->$code_field != 'paid') {
            $payments = 0;
            if ($item->$code_field == 'partial') {
                foreach ($item->payments as $payment) {
                    $payments += $payment->getConvertedAmount();
                }
            }

            if ($item->due_at > $today) {
                $open += $item->getConvertedAmount() - $payments;
            } else {
                $overdue += $item->getConvertedAmount() - $payments;
            }
        }

        return array($paid, $open, $overdue);
    }

    private function addToIncomeDonut($color, $amount, $text)
    {
        $this->income_donut['colors'][] = $color;
        $this->income_donut['labels'][] = money($amount, $this->company->default_currency, true)->format() . ' - ' . $text;
        $this->income_donut['values'][] = (int) $amount;
    }

    private function addToExpenseDonut($color, $amount, $text)
    {
        $this->expense_donut['colors'][] = $color;
        $this->expense_donut['labels'][] = money($amount, $this->company->default_currency, true)->format() . ' - ' . $text;
        $this->expense_donut['values'][] = (int) $amount;
    }

    private function calculateCashFlowTotals($type, $start, $end, $period)
    {
        $totals = array();

        if ($type == 'income') {
            $m1 = '\App\Models\Revenue';
            $m2 = '\App\Models\InvoicePayment';
        } else {
            $m1 = '\App\Models\Payment';
            $m2 = '\App\Models\BillPayment';
        }

        $date_format = 'Y-m';

        if ($period == 'month') {
            $n = 1;
            $start_date = $start->format($date_format);
            $end_date = $end->format($date_format);
            $next_date = $start_date;
        } else {
            $n = 3;
            $start_date = $start->quarter;
            $end_date = $end->quarter;
            $next_date = $start_date;
        }

        $s = clone $start;

        //$totals[$start_date] = 0;
        while ($next_date <= $end_date) {
            $totals[$next_date] = 0;

            if ($period == 'month') {
                $next_date = $s->addMonths($n)->format($date_format);
            } else {
                if (isset($totals[4])) {
                    break;
                }

                $next_date = $s->addMonths($n)->quarter;
            }
        }

        $items_1 = $m1::whereBetween('paid_at', [$start, $end])->isNotTransfer()->get();

        $this->setCashFlowTotals($totals, $items_1, $date_format, $period);

        $items_2 = $m2::whereBetween('paid_at', [$start, $end])->get();

        $this->setCashFlowTotals($totals, $items_2, $date_format, $period);

        return $totals;
    }

    private function calculateCashFlowProfit($incomes, $expenses)
    {
        $profit = [];

        foreach ($incomes as $key => $income) {
            if ($income > 0 && $income > $expenses[$key]) {
                $profit[$key] = $income - $expenses[$key];
            } else {
                $profit[$key] = 0;
            }
        }

        return $profit;
    }

    private function setCashFlowTotals(&$totals, $items, $date_format, $period)
    {
        foreach ($items as $item) {
            if ($period == 'month') {
                $i = Carbon::parse($item->paid_at)->format($date_format);
            } else {
                $i = Carbon::parse($item->paid_at)->quarter;
            }

            if (!isset($totals[$i])) {
                continue;
            }

            $totals[$i] += $item->getConvertedAmount();
        }
    }
}
