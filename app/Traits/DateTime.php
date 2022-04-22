<?php

namespace App\Traits;

use App\Models\Company;
use Carbon\Carbon;
use Session;


trait DateTime
{

    public function scopeMonthsOfYear($query, $field)
    {


        $year = request('year', Carbon::now()->year);

        $start = Carbon::parse($year . '-01-01')->startOfDay()->format('Y-m-d H:i:s');
        $end = Carbon::parse($year . '-12-31')->endOfDay()->format('Y-m-d  H:i:s');

        // check if financial year has been customized
        $financial_start = $this->getFinancialStart();

        if (Carbon::now()->startOfYear()->format('Y-m-d') !== $financial_start->format('Y-m-d')) {
            if (!is_null(request('year'))) {
                $financial_start->year = $year;
            }

            $start = $financial_start->format('Y-m-d');
            $end = $financial_start->addYear(1)->subDays(1)->format('Y-m-d');
        }

        return $query->whereBetween($field, [$start, $end]);
    }

    public function getFinancialStart()
    {
        $company = Company::findOrFail(Session::get('company_id'));
        $company->setSettings();
        $now = Carbon::now()->startOfYear();
        $setting = explode('-', $company->financial_start);
        $day = !empty($setting[0]) ? $setting[0] : $now->day;
        $month = !empty($setting[1]) ? $setting[1] : $now->month;
        return Carbon::create(null, $month, $day);
    }
}
