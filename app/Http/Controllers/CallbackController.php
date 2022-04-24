<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\FacebookApp;
use Illuminate\Http\Request;
use App\Models\FacebookUser;
use App\Models\FacebookPage;
use App\Models\FacebookGroup;
use Illuminate\Support\Facades\Http;
use App\Libraries\Facebook\NextFacebook;

class CallbackController extends Controller
{
    /**
     * login callback
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function loginCallback(Request $request)
    {
        $redirectUrl = url('/fb-login-callback');
        $roleName = Auth::user()->getRoleNames();
        $userFbAppIdStr = $request->state;
        $userFbAppIdArray = explode("_", $userFbAppIdStr);
        $userId = $userFbAppIdArray[0];
        $fbAppId = $userFbAppIdArray[1];

        $facebookApp = FacebookApp::find($fbAppId);
        $callbackResponse = Http::get('https://graph.facebook.com/v13.0/oauth/access_token?client_id=' . $facebookApp->api_id . '&redirect_uri=' . urlencode($redirectUrl) . '&client_secret=' . $facebookApp->api_secret . '&code=' . $request->code);
        $callbackResponseObject = $callbackResponse->object();

        $nextFb =  new NextFacebook($facebookApp);
        $response = $nextFb->loginCallback($callbackResponseObject->access_token);

        if (isset($response['error'])) {
            return redirect()->route('connect-account.index')->with('error', $response['error']['message']);
        } else {
            ($roleName['0'] == "Super Admin") ?  $useBy = "everyone" : $useBy = "only_me";
            $accessToken = $response['accessToken'];
            $facebookApp->user_access_token = $accessToken;
            $facebookApp->use_by = $useBy;
            $facebookApp->save();

            $facebookUserId = $this->updateOrCreateFbUser($userId, $fbAppId, $accessToken, $response);
            $pageList = $nextFb->getPageList($accessToken);
            if (!empty($pageList)) {
                $this->updateOrCreateFbPage($userId, $pageList, $facebookUserId);
            }

            return redirect()->route('connect-account.index')->with('success', trans('Facebook Account Connect Successfully'));
        }
    }

    /**
     * update or create fb user
     *
     * @param [type] $userId
     * @param [type] $fbAppId
     * @param [type] $accessToken
     * @param [type] $response
     * @return int
     */
    public function updateOrCreateFbUser($userId, $fbAppId, $accessToken, $response)
    {
        $data = array('config_id' => $fbAppId, 'access_token' => $accessToken, 'name' => isset($response['name']) ? $response['name'] : "", 'email' => isset($response['email']) ? $response['email'] : "");
        $where = array('user_id' => $userId, 'facebook_id' => $response['id']);
        $facebookUser = FacebookUser::updateOrCreate($where, $data);
        return $facebookUser->id;
    }

    /**
     * update or create fb page
     *
     * @param [type] $userId
     * @param [type] $pageList
     * @param [type] $facebookUserId
     * @return bool
     */
    public function updateOrCreateFbPage($userId, $pageList, $facebookUserId)
    {
        foreach ($pageList as $page) {
            $userId = $userId;
            $pageId = $page['id'];
            $pageCover = '';
            if (isset($page['cover']['source']))
                $pageCover = $page['cover']['source'];
            $pageProfile = '';
            if (isset($page['picture']['data']['url']))
                $pageProfile = $page['picture']['data']['url'];
            $pageName = '';
            if (isset($page['name']))
                $pageName = $page['name'];
            $pageUsername = '';
            if (isset($page['username']))
                $pageUsername = $page['username'];
            $pageAccessToken = '';
            if (isset($page['access_token']))
                $pageAccessToken = $page['access_token'];
            $pageEmail = '';
            if (isset($page['emails'][0]))
                $pageEmail = $page['emails'][0];

            $data = array('facebook_user_id' => $facebookUserId, 'page_cover' => $pageCover, 'page_profile' => $pageProfile, 'page_name' => $pageName, 'username' => $pageUsername, 'page_access_token' => $pageAccessToken, 'page_email' => $pageEmail);
            $where = array('user_id' => $userId, 'page_id' => $pageId);
            FacebookPage::updateOrCreate($where, $data);
        }
        return true;
    }
}
