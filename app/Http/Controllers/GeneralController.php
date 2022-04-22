<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{

    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:company-read|company-update', ['only' => ['index']]);
        $this->middleware('permission:company-update', ['only' => ['edit','localisation', 'bill', 'invoice', 'defaults']]);
    }

	/**
     * Method to load general view
     *
     * @access public
     * @return mixed
     */
    public function index() {
        if (empty(Session::get('company_id'))) {
            return redirect()->route('company.index')->withError('Create Company First');
        } else {
            $id = Session::get('company_id');
            $company = Company::findOrFail($id);
            $company->setSettings();
            $currencies = Currency::where('company_id',$id)->pluck('name', 'code');
            $timezone = $this->timeZones();
            $priceNames = [
                'settings.invoice.price' => 'settings.invoice.price',
                'settings.invoice.rate' => 'settings.invoice.rate'
            ];
            $itemNames = [
                'settings.invoice.item' => 'settings.invoice.item',
                'settings.invoice.product' => 'settings.invoice.product',
                'settings.invoice.service' =>  'settings.invoice.service'
            ];
            return view('settings.general.index', compact('company','currencies','timezone','priceNames','itemNames'));
        }
    }

    /**
 	* Method to check general section edit
 	*
 	* @access public
 	* @param Request $request
    */
 	public function edit(Request $request) {
        $this->validate($request, [
            'company_name' => 'required',
            'company_email' => 'required',
            'company_address' => 'required'
        ]);
 		$this->validate($request,['company_logo' => 'image|mimes:png,jpg,jpeg']);
 		$id = Session::get('company_id');
 		$data = Setting::where('company_id', $id)->get();
 		$company = Company::findOrFail($id);
        $company->setSettings();
        // tax number
		if (array_key_exists("company_tax_number", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.company_tax_number')
                ->update(['value' => $request->company_tax_number]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.company_tax_number', 'value' => $request->company_tax_number]);
		}

		// phone
		if (array_key_exists("company_phone", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.company_phone')
                ->update(['value' => $request->company_phone]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.company_phone', 'value' => $request->company_phone]);
		}

		// Logo
		if($request->hasFile('company_logo'))
        {
            $logo = $request->company_logo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('uploads/companies',$logoNewName);
            $logo = 'uploads/companies/'.$logoNewName;

            if ($company->company_logo != 'public/img/company.png') {
	            $data = Setting::where('company_id', $id)
	                ->where('key', 'general.company_logo')
	                ->update(['value' => $logo]);
			} else {
			  	$data = Setting::create(['company_id' => $id, 'key' => 'general.company_logo', 'value' => $logo]);
			}
        }

        if (array_key_exists("company_name", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.company_name')
                ->update(['value' => $request->company_name]);
        }

        if (array_key_exists("company_email", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.company_email')
                ->update(['value' => $request->company_email]);
        }

        if (array_key_exists("company_address", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.company_address')
                ->update(['value' => $request->company_address]);
        }

        if($data) {
        	return redirect()->route('general')->withSuccess(trans('Company Information Updated Successfully'));
        } else {
        	return redirect()->back()->withErrors(trans('Something Went Wrong, Please Try Again'));
        }
 	}

 	/**
 	* Method to check general localisation section edit
 	*
 	* @access public
 	* @param Request $request
    */
 	public function localisation(Request $request) {

 		$id = Session::get('company_id');
 		$data = Setting::where('company_id', $id)->get();
 		$company = Company::findOrFail($id);
        $company->setSettings();

        // financial_start
		if (array_key_exists("financial_start", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.financial_start')
                ->update(['value' => $request->financial_start]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.financial_start', 'value' => $request->financial_start]);
		}

		// timezone
		if (array_key_exists("timezone", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.timezone')
                ->update(['value' => $request->timezone]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.timezone', 'value' => $request->timezone]);
		}

		// date_format
		if (array_key_exists("date_format", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.date_format')
                ->update(['value' => $request->date_format]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.date_format', 'value' => $request->date_format]);
		}

		// date_separator
		if (array_key_exists("date_separator", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.date_separator')
                ->update(['value' => $request->date_separator]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.date_separator', 'value' => $request->date_separator]);
		}

		// percent_position
		if (array_key_exists("percent_position", $company->toArray())) {
            $data = Setting::where('company_id', $id)
                ->where('key', 'general.percent_position')
                ->update(['value' => $request->percent_position]);
		} else {
		  	$data = Setting::create(['company_id' => $id, 'key' => 'general.percent_position', 'value' => $request->percent_position]);
		}

        if($data) {
        	return redirect()->route('general')->withSuccess(trans('Localisation Information Updated Successfully'));
        } else {
        	return redirect()->back()->withErrors(trans('Something Went Wrong, Please Try Again'));
        }
 	}

    /**
 	* Method to check general bill section edit
 	*
 	* @access public
 	* @param Request $request
    */
    public function bill(Request $request) {
        $id = Session::get('company_id');
        $data = Setting::where('company_id', $id)->get();
        $company = Company::findOrFail($id);
        $company->setSettings();
        // bill_number_prefix
        if (array_key_exists("bill_number_prefix", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.bill_number_prefix')->update(['value' => $request->bill_number_prefix]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.bill_number_prefix', 'value' => $request->bill_number_prefix]);
        }

        // bill_number_digit
        if (array_key_exists("bill_number_digit", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.bill_number_digit')->update(['value' => $request->bill_number_digit]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.bill_number_digit', 'value' => $request->bill_number_digit]);
        }

        // bill_number_next
        if (array_key_exists("bill_number_next", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.bill_number_next')->update(['value' => $request->bill_number_next]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.bill_number_next', 'value' => $request->bill_number_next]);
        }

        // bill_item
        if (array_key_exists("bill_item", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.bill_item')->update(['value' => $request->bill_item]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.bill_item', 'value' => $request->bill_item]);
        }

        if($data) {
            return redirect()->route('general')->withSuccess(trans('Bill Information Updated Successfully'));
        } else {
            return redirect()->back()->withErrors(trans('Something Went Wrong, Please Try Again'));
        }
    }

    /**
 	* Method to check general invoice section edit
 	*
 	* @access public
 	* @param Request $request
    */
 	public function invoice(Request $request) {
        $id = Session::get('company_id');
        $data = Setting::where('company_id', $id)->get();
        $company = Company::findOrFail($id);
        $company->setSettings();
        // invoice_number_prefix
        if (array_key_exists("invoice_number_prefix", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.invoice_number_prefix')->update(['value' => $request->invoice_number_prefix]);
        } else {
             $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_number_prefix', 'value' => $request->invoice_number_prefix]);
       }

       // invoice_number_digit
       if (array_key_exists("invoice_number_digit", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.invoice_number_digit')->update(['value' => $request->invoice_number_digit]);
       } else {
             $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_number_digit', 'value' => $request->invoice_number_digit]);
       }

       // invoice_number_next
       if (array_key_exists("invoice_number_next", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.invoice_number_next')->update(['value' => $request->invoice_number_next]);
       } else {
             $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_number_next', 'value' => $request->invoice_number_next]);
       }

       // invoice_item
       if (array_key_exists("invoice_item", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.invoice_item')->update(['value' => $request->invoice_item]);
       } else {
             $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_item', 'value' => $request->invoice_item]);
       }

       // invoice_price
       if (array_key_exists("invoice_price", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.invoice_price')->update(['value' => $request->invoice_price]);
       } else {
             $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_price', 'value' => $request->invoice_price]);
       }

       // invoice_quantity
       if (array_key_exists("invoice_quantity", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.invoice_quantity')->update(['value' => $request->invoice_quantity]);
       } else {
             $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_quantity', 'value' => $request->invoice_quantity]);
       }

        //send_item_reminder
        if (array_key_exists("send_item_reminder", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.send_item_reminder')->update(['value' => $request->send_item_reminder]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.send_item_reminder', 'value' => $request->send_item_reminder]);
        }

        //schedule_item_stocks
        if (array_key_exists("schedule_item_stocks", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.schedule_item_stocks')->update(['value' => $request->schedule_item_stocks]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.schedule_item_stocks', 'value' => $request->schedule_item_stocks]);
        }

       // Logo
       if($request->hasFile('invoice_logo'))
       {
           $logo = $request->invoice_logo;
           $logoNewName = time().$logo->getClientOriginalName();
           $logo->move('uploads/companies/invoices/',$logoNewName);
           $logo = 'uploads/companies/invoices/'.$logoNewName;
           if (array_key_exists("invoice_logo", $company->toArray())) {
               $data = Setting::where('company_id', $id)->where('key', 'general.invoice_logo')->update(['value' => $logo]);
           } else {
                 $data = Setting::create(['company_id' => $id, 'key' => 'general.invoice_logo', 'value' => $logo]);
           }
       }
       if($data) {
           return redirect()->route('general')->withSuccess(trans('Invoice Information Updated Successfully'));
       } else {
           return redirect()->back()->withErrors(trans('Something Went Wrong, Please Try Again'));
       }
    }

     	/**
 	* Method to check general defaults section edit
 	*
 	* @access public
 	* @param Request $request
    */
 	public function defaults(Request $request) {
        $id = Session::get('company_id');
        $data = Setting::where('company_id', $id)->get();
        $company = Company::findOrFail($id);
        $company->setSettings();
        // default_account
        if (array_key_exists("default_account", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.default_account')->update(['value' => $request->default_account]);
            $data  = $company->accounts()->where('company_id', $id)->update(['enabled' => 0]);
            $data  = $company->accounts()->where('id', $request->default_account)->update(['enabled' => 1]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.default_account', 'value' => $request->default_account]);
            $data  = $company->accounts()->where('company_id', $id)->update(['enabled' => 0]);
            $data  = $company->accounts()->where('id', $request->default_account)->update(['enabled' => 1]);
        }

        // default_currency
        if (array_key_exists("default_currency", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.default_currency')->update(['value' => $request->default_currency]);
            $data  = $company->currencies()->where('company_id', $id)->update(['enabled' => 0]);
            $data  = $company->currencies()->where('id', $request->default_currency)->update(['enabled' => 1]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.default_currency', 'value' => $request->default_currency]);
            $data  = $company->currencies()->where('company_id', $id)->update(['enabled' => 0]);
            $data  = $company->currencies()->where('id', $request->default_currency)->update(['enabled' => 1]);
        }

        // default_tax
        if (array_key_exists("default_tax", $company->toArray())) {
           $data = Setting::where('company_id', $id)->where('key', 'general.default_tax')->update(['value' => $request->default_tax]);
           $data  = $company->taxes()->where('company_id', $id)->update(['enabled' => 0]);
           $data  = $company->taxes()->where('id', $request->default_tax)->update(['enabled' => 1]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.default_tax', 'value' => $request->default_tax]);
            $data  = $company->taxes()->where('company_id', $id)->update(['enabled' => 0]);
            $data  = $company->taxes()->where('id', $request->default_tax)->update(['enabled' => 1]);
        }

        // default_payment_method
        if (array_key_exists("default_payment_method", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.default_payment_method')->update(['value' => $request->default_payment_method]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.default_payment_method', 'value' => $request->default_payment_method]);
        }

        // default_locale
        if (array_key_exists("default_locale", $company->toArray())) {
            $data = Setting::where('company_id', $id)->where('key', 'general.default_locale')->update(['value' => $request->default_locale]);
        } else {
            $data = Setting::create(['company_id' => $id, 'key' => 'general.default_locale', 'value' => $request->default_locale]);
        }

        if($data) {
            return redirect()->route('general')->withSuccess(trans('Default Information Updated Successfully'));
        } else {
            return redirect()->back()->withErrors(trans('Something Went Wrong, Please Try Again'));
        }
    }
}
