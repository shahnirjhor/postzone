<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ApplicationSetting;

/**
 * Class ApplicationSettingController
 *
 * @package App\Http\Controllers
 * @category Controller
 */
class ApplicationSettingController extends Controller
{
    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        $this->middleware('role:Super Admin', ['only' => ['index','update']]);
    }

    /**
     * Method to load view
     *
     * @access public
     * @return mixed
     */
    public function index()
    {
        $timezone = $this->timeZones();
        $data = ApplicationSetting::find(1);
        return view('admin.application_setting', compact('data', 'timezone'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @access public
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        if(Str::length($request->address) == 11)
        {
            $request->address = NULL;
        }

        $this->validate($request,[
            'item_name' => 'required',
            'item_short_name' => 'required',
            'company_name' => 'required',
            'time_zone' => 'required',
            'language' => 'required',
            'address' => 'required|min:12',
            'company_email' => 'required|email',
            'logo' => 'image|mimes:png|max:2048',
            'favicon' => 'image|mimes:png,ico|max:2048'
        ]);

        if($request->hasFile('logo'))
        {
            $logo_text = $request->logo;
            $logo_text_new_name = 'logo-text.png';
            $logo_text->move('img/', $logo_text_new_name);
        }

        if($request->hasFile('favicon'))
        {
            $favicon = $request->favicon;
            $favicon_new_name = 'favicon.png';
            $favicon->move('img/', $favicon_new_name);
            $favicon = 'favicon.png';
        } else {
            $favicon = 'favicon.png';
        }

        $data = ApplicationSetting::updateOrCreate(['id' => "1"], [
            'item_name' => $request->item_name,
            'item_short_name' => $request->item_short_name,
            'company_name' => $request->company_name,
            'company_address' => $request->address,
            'company_email' => $request->company_email,
            'language' => $request->language,
            'time_zone' => $request->time_zone,
            'favicon' => $favicon,
        ]);

        $currentLang = env('LOCALE_LANG', 'en');
        $defaultLang = $request->language;

        if($currentLang != $defaultLang) {
            if (!$this->locale($defaultLang))
            {
                $message = "Database Connection Error !!!";
            }
        }
        return redirect()->route('apsetting')->withSuccess(trans('Application Settings Has Updated'));
    }

    /**
     * Method to call updateEnvFile
     *
     * @param $smtpHost
     * @param $smtpPort
     * @param $smtpUser
     * @param $smtpPassword
     * @param $smtpType
     */
    public function env($smtpHost, $smtpPort, $smtpUser, $smtpPassword, $smtpType)
    {
        $this->updateEnvfile([
            'MAIL_HOST' => $smtpHost,
            'MAIL_PORT'   => $smtpPort,
            'MAIL_USERNAME'   => $smtpUser,
            'MAIL_PASSWORD'   => $smtpPassword,
            'MAIL_ENCRYPTION'   => $smtpType,
        ]);
    }

    /**
     * Method to update env file
     *
     * @param $data
     *
     * @return bool
     */
    public function updateEnvfile($data)
    {
        if(empty($data)||!is_array($data)||!is_file(base_path('.env')))
        {
            return false;
        }
        $env = file_get_contents(base_path('.env'));
        $env = explode("\n", $env);
        foreach ($data as $dataKey => $dataValue) {
            $updated = false;
            foreach ($env as $envKey => $envValue) {
                $entry = explode('=', $envValue, 2);
                if ($entry[0] == $dataKey) {
                    $env[$envKey] = $dataKey . '=' . $dataValue;
                    $updated = true;
                } else {
                    $env[$envKey] = $envValue;
                }
            }
            if (!$updated) {
                $env[] = $dataKey . '=' . $dataValue;
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path('.env'), $env);
        Artisan::call('config:clear');
        return true;
    }

     /**
     * Method to call localeUpdateEnvfile
     *
     * @param $defaultLang
     */
    public function locale($defaultLang)
    {
        $this->localeUpdateEnvfile([
            'LOCALE_LANG' => $defaultLang,
        ]);
    }

    /**
     * Method to update env file
     *
     * @param $data
     *
     * @return bool
     */
    public function localeUpdateEnvfile($data)
    {
        if(empty($data)||!is_array($data)||!is_file(base_path('.env')))
        {
            return false;
        }
        $env = file_get_contents(base_path('.env'));
        $env = explode("\n", $env);
        foreach ($data as $dataKey => $dataValue) {
            $updated = false;
            foreach ($env as $envKey => $envValue) {
                $entry = explode('=', $envValue, 2);
                if ($entry[0] == $dataKey) {
                    $env[$envKey] = $dataKey . '=' . $dataValue;
                    $updated = true;
                } else {
                    $env[$envKey] = $envValue;
                }
            }
            if (!$updated) {
                $env[] = $dataKey . '=' . $dataValue;
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path('.env'), $env);
        Artisan::call('config:clear');
        return true;
    }


}
