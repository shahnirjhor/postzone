<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmtpConfiguration;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\DB;

class SmtpConfigurationController extends Controller
{
    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        $this->middleware('role:Super Admin', ['only' => ['index','create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = SmtpConfiguration::latest()->paginate(10);
        return view('admin.smpt.list')->with('lists', $lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.smpt.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email_address' => 'required|email',
            'smtp_host' => 'required',
            'smtp_port' => 'required',
            'smtp_user' => 'required',
            'smtp_password' => 'required',
            'smtp_type' => 'required',
            'status' => 'required'
        ]);

        $userId = auth()->user()->id;
        /**
         * Method to call db transaction
         */
        DB::beginTransaction();
        try {
            $smtpConfiguration = SmtpConfiguration::create([
                'email_address' => $request->email_address,
                'smtp_host' => $request->smtp_host,
                'smtp_port' => $request->smtp_port,
                'smtp_user' => $request->smtp_user,
                'smtp_password' => $request->smtp_password,
                'smtp_type' => $request->smtp_type,
                'status' => $request->status
            ]);
            $tableId = $smtpConfiguration->id;
            if( $request->status == '1')
            {
                DB::table('smtp_configurations')->where('id', '!=', $tableId)->update(['status' => '0']);
            }

            DB::commit();
            return redirect()->route('smtp.index')->withSuccess(trans('New Smtp Information Inserted Successfully'));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('smtp.create')->withErrors([trans('Oops Something Wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmtpConfiguration  $smtpConfiguration
     * @return \Illuminate\Http\Response
     */
    public function show(SmtpConfiguration $smtp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmtpConfiguration  $smtpConfiguration
     * @return \Illuminate\Http\Response
     */
    public function edit(SmtpConfiguration $smtp)
    {
        $data = $smtp;
        return view('admin.smpt.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmtpConfiguration  $smtpConfiguration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmtpConfiguration $smtp)
    {
        $smtpConfiguration = $smtp;

        $this->validate($request, [
            'email_address' => 'required|email',
            'smtp_host' => 'required',
            'smtp_port' => 'required',
            'smtp_user' => 'required',
            'smtp_password' => 'required',
            'smtp_type' => 'required',
            'status' => 'required'
        ]);

        $applicationSetting = ApplicationSetting::first();
        if($applicationSetting->is_demo == "1")
        {
            session()->flash('demo_error', trans('This Feature Is Disabled In Demo Version'));
            return redirect()->back();
        }

        /**
         * Method to call db transaction
         */
        DB::beginTransaction();
        try
        {
            $smtpConfiguration->email_address = $request->email_address;
            $smtpConfiguration->smtp_host = $request->smtp_host;
            $smtpConfiguration->smtp_port = $request->smtp_port;
            $smtpConfiguration->smtp_user = $request->smtp_user;
            $smtpConfiguration->smtp_password = $request->smtp_password;
            $smtpConfiguration->smtp_type = $request->smtp_type;
            $smtpConfiguration->status = $request->status;
            $smtpConfiguration->save();
            if( $request->status == '1')
            {
                DB::table('smtp_configurations')->where('id', '!=', $smtpConfiguration->id)->update(['status' => '0']);
            }

            DB::commit();
            return redirect()->route('smtp.index')->withSuccess(trans('Smtp Information Updated Successfully'));
         } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors([trans('Oops Something Wrong')]);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmtpConfiguration  $smtp
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmtpConfiguration $smtp)
    {
        $smtpConfiguration = $smtp;
        $applicationSetting = ApplicationSetting::first();
        if($applicationSetting->is_demo == "1")
        {
            echo json_encode(array("success"=>2,"error"=>"<div class='alert alert-success text-center'>This Feature Is Disabled In Demo Version</div>"));
            return redirect()->back();
        }

        if($smtpConfiguration->status == "1")
        {
            $env = SmtpConfiguration::where('status', '1')->get()->first();
            $smtp_host = null;
            $smtp_port = null;
            $smtp_user = null;
            $smtp_password = null;
            $smtp_type = null;
        }

        if($smtpConfiguration->delete())
            return redirect()->route('smtp.index')->withSuccess(trans('Smtp Information Deleted Successfully'));
        else
            return redirect()->back()->withErrors(trans('Oops Something Wrong'));
    }
}
