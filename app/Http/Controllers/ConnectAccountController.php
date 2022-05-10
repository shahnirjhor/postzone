<?php

namespace App\Http\Controllers;

use App\Models\FacebookApp;
use Illuminate\Http\Request;
use App\Libraries\Facebook\NextFacebook;
use App\Models\FacebookPage;
use App\Models\FacebookUser;

class ConnectAccountController extends Controller
{
    protected $nextFb;

    /**
    * load constructor method
    * @access public
    * @return void
    */
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            $facebookApp = FacebookApp::where('user_id', auth()->id())->first();
            $this->nextFb =  new NextFacebook($facebookApp);

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $redirectUrl = "/refresh-token-callback";
        $loginButton = $this->nextFb->fbRefreshLogin($redirectUrl);
        $data['loginButton'] = $loginButton;

        $existingFbAccounts = FacebookUser::where('user_id', auth()->user()->id)->get();
        $data['showConnectAccountBox'] = 1;
        if (!empty($existingFbAccounts)) {
            $i = 0;
            foreach ($existingFbAccounts as $value) {
                $existingFbAccountsInfo[$i]['need_to_delete'] = $value->need_to_delete;
                if ($value->need_to_delete == '1') {
                    $showConnectAccountBox = 0;
                    $data['showConnectAccountBox'] = $showConnectAccountBox;
                }
                $existingFbAccountsInfo[$i]['id'] = $value->id;
                $existingFbAccountsInfo[$i]['fb_id'] = $value->facebook_id;
                $existingFbAccountsInfo[$i]['fb_user_table_id'] = $value->id;
                $existingFbAccountsInfo[$i]['name'] = $value->name;
                $existingFbAccountsInfo[$i]['email'] = $value->email;
                $existingFbAccountsInfo[$i]['user_access_token'] = $value->access_token;

                $validOrInvalid = $this->nextFb->accessTokenValidityForUser($value->access_token);
                if ($validOrInvalid) {
                    $existingFbAccountsInfo[$i]['validity'] = 'yes';
                } else {
                    $existingFbAccountsInfo[$i]['validity'] = 'no';
                }

                $allPage = FacebookPage::where('facebook_user_id', $value->id)->get();
                $existingFbAccountsInfo[$i]['page_list'] = $allPage;

                if (!empty($allPage)) {
                    $existingFbAccountsInfo[$i]['total_pages'] = $allPage->count();
                } else {
                	$existingFbAccountsInfo[$i]['total_pages'] = 0;
                }

                $i++;
            }
            $data['existingFbAccounts'] = $existingFbAccountsInfo ?? null;
        } else {
            $data['existingFbAccounts'] = '0';
        }

        // dd($data);

        return view('connect-account.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
