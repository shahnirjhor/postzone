<?php

namespace App\Http\Controllers;

use App\Models\FacebookApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Libraries\Facebook\NextFacebook;

class FacebookAppController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @access public
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $apps = $this->filter($request)->paginate(10)->withQueryString()->toArray();
        $tokenValidity = $this->tokenValidity($apps['data']);
        unset($apps['data']);

        if(isset($apps) && !empty($apps)) {
            $apps['data'] = $tokenValidity;
        }


        // dd($apps);
        return view('facebook-app.index',compact('apps'));
    }



    private function tokenValidity($datas)
    {
        $appData = [];
        if (!empty($datas)) {
            $i = 0;
            foreach ($datas as $value) {

                $input_token = $value['user_access_token'];
                if ($input_token == "" || $input_token == NULL)
                    $token_validity = "invalid";

                $url = "https://graph.facebook.com/debug_token?input_token={$input_token}&access_token={$input_token}";
                $response = Http::get($url);
                $response = $response->json();
                if (isset($response["data"]["is_valid"]) && $response["data"]["is_valid"]) {
                    $token_validity = "valid";
                } else {
                    $token_validity = "expired";
                }

                $appData[$i]['id'] = $value['id'];
                $appData[$i]['user_id'] = $value['user_id'];
                $appData[$i]['api_id'] = $value['api_id'];
                $appData[$i]['app_name'] = $value['app_name'];
                $appData[$i]['api_secret'] = $value['api_secret'];
                $appData[$i]['numeric_id'] = $value['numeric_id'];
                $appData[$i]['user_access_token'] = $value['user_access_token'];
                $appData[$i]['developer_access'] = $value['developer_access'];
                $appData[$i]['facebook_id'] = $value['facebook_id'];
                $appData[$i]['secret_code'] = $value['secret_code'];
                $appData[$i]['use_by'] = $value['use_by'];
                $appData[$i]['token_validity'] = $token_validity;
                $appData[$i]['status'] = $value['status'];
                $appData[$i]['created_at'] = $value['created_at'];
                $appData[$i]['updated_at'] = $value['updated_at'];
                $appData[$i]['deleted_at'] = $value['deleted_at'];
                $i++;
            }
        }

        return $appData;
    }

    /**
     * Filter function
     *
     * @param Request $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        $query = FacebookApp::orderBy('id','DESC');

        if ($request->app_name)
            $query->where('app_name', 'like', $request->app_name.'%');

        if ($request->api_id)
            $query->where('api_id', 'like', $request->api_id.'%');

        return $query;
    }

    public function fbLogin($id=0)
    {
        $data = [];
        $facebookApp = FacebookApp::find($id);
        $nextFb =  new NextFacebook($facebookApp);

        $loginButton = $nextFb->fbLogin();
        $expiredOrNot = $nextFb->accessTokenValidity();

        // dd($expiredOrNot);

        $data['loginButton'] = $loginButton;
        $data['expiredOrNot'] = $expiredOrNot;

        return view('facebook-app.login', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facebook-app.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $data = $request->only(['app_name', 'api_id', 'api_secret', 'status']);
        $data['user_id'] = auth()->user()->id;

        DB::transaction(function () use ($data) {
            FacebookApp::create($data);
        });

        return redirect()->route('facebook-apps.index')->with('success', trans('Facebook App Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacebookApp  $facebookApp
     * @return \Illuminate\Http\Response
     */
    public function show(FacebookApp $facebookApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacebookApp  $facebookApp
     * @return \Illuminate\Http\Response
     */
    public function edit(FacebookApp $facebookApp)
    {
        return view('facebook-app.edit', compact('facebookApp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacebookApp  $facebookApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacebookApp $facebookApp)
    {
        $this->validation($request);
        $data = $request->only(['app_name', 'api_id', 'api_secret', 'status']);
        $data['user_id'] = auth()->user()->id;
        $facebookApp->update($data);

        return redirect()->route('facebook-apps.index')->with('success', trans('Facebook App Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacebookApp  $facebookApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacebookApp $facebookApp)
    {
        $facebookApp->delete();
        return redirect()->route('facebook-apps.index')->with('success', trans('Facebook App Deleted Successfully'));
    }

    /**
     * validation function
     *
     * @param Request $request
     * @return array
     */
    private function validation(Request $request)
    {
        return $this->validate($request, [
            'app_name' => ['required', 'string', 'max:255'],
            'api_id' => ['required', 'string', 'max:255'],
            'api_secret' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:0,1']
        ]);
    }
}
