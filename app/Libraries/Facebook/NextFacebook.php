<?php

namespace App\Libraries\Facebook;

use App\Models\FacebookApp;
use Illuminate\Support\Facades\Http;

class NextFacebook
{
    protected $FACEBOOK_API_PREFIX = 'https://www.facebook.com/v13.0';
    protected $FACEBOOK_GRAPH_API_PREFIX = 'https://graph.facebook.com/v13.0';

    protected $localAppId;
    protected $appId;
    protected $appSecret;
    protected $accessToken;

    public function __construct(FacebookApp $facebookApp)
    {
        $this->localAppId = $facebookApp->id;
        $this->appId = $facebookApp->api_id;
        $this->appSecret = $facebookApp->api_secret;
        $this->accessToken = $facebookApp->user_access_token;
    }

    public function fbLogin()
    {
        $callbackUrl = urlencode(url('/fb-login-callback'));
        $scopes = urlencode('email,public_profile,pages_show_list,pages_manage_posts,publish_to_groups');
        $redirectUrl = $this->FACEBOOK_API_PREFIX.'/dialog/oauth?client_id=' . $this->appId . '&state=' . auth()->id() . '_' . $this->localAppId . '&response_type=code&sdk=php-sdk-5.1.4&redirect_uri=' . $callbackUrl . "&scope=" . $scopes;

        return $redirectUrl;
    }

    public function fbRefreshLogin($redirectUrl="")
    {
        //refresh-token-callback
        $callbackUrl = urlencode(url($redirectUrl));
        $scopes = urlencode('email,public_profile,pages_show_list,pages_manage_posts,publish_to_groups');
        $redirectUrl = $this->FACEBOOK_API_PREFIX.'/dialog/oauth?client_id=' . $this->appId . '&state=' . auth()->id() . '_' . $this->localAppId . '&response_type=code&sdk=php-sdk-5.1.4&redirect_uri=' . $callbackUrl . "&scope=" . $scopes;

        return $redirectUrl;
    }

    public function loginCallback($accessToken)
    {
        $url = $this->FACEBOOK_GRAPH_API_PREFIX . "/me?fields=id,name,email&access_token={$accessToken}";
        $response = Http::get($url);
        $response = $response->json();

        if (isset($response['error']))
            return $response;

        $accessToken = (string) $accessToken;
        $accessToken = $this->longLivedAccessToken($accessToken);
        $response["accessToken"] = $accessToken;

        return $response;
    }

    public function debugAccessToken($inputToken){
		$url="https://graph.facebook.com/debug_token?input_token={$inputToken}&access_token={$this->accessToken}";
		$response = Http::get($url);
        $result = $response->json();
        return $result;
	}

    public function longLivedAccessToken($passToken)
    {
        $appId = $this->appId;
        $appSecret = $this->appSecret;
        $shortToken = $passToken;
        $url = $this->FACEBOOK_GRAPH_API_PREFIX . "/oauth/access_token?grant_type=fb_exchange_token&client_id={$appId}&client_secret={$appSecret}&fb_exchange_token={$shortToken}";
        $response = Http::get($url);
        $result = $response->object();
        $longToken = isset($result->access_token) ? $result->access_token : "";

        return $longToken;
    }

    public function accessTokenValidity()
    {
        $accessToken = $this->accessToken;
        $clientId = $this->appId;
        $url = $this->FACEBOOK_GRAPH_API_PREFIX . "/oauth/access_token_info?client_id={$clientId}&access_token={$accessToken}";

        $response = Http::get($url);
        $result = $response->json();

        if(isset($result["access_token"]) && !empty($result["access_token"])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function accessTokenValidityForUser($accessToken)
    {
        $appId = $this->appId;
        $url = $this->FACEBOOK_GRAPH_API_PREFIX . "/oauth/access_token_info?client_id={$appId}&access_token={$accessToken}";
        $response = Http::get($url);
        $response = $response->json();
        if (!isset($result["error"])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getPageList($accessToken = "")
    {
        $url = $this->FACEBOOK_GRAPH_API_PREFIX . "/me/accounts?fields=cover,emails,picture,id,name,username,access_token&limit=400&access_token={$accessToken}";
        $response = Http::get($url);
        $response = $response->json();

        if (isset($response['error']))
            return [];

        return $response['data'];
    }

    public function getGroupList($accessToken="")
	{
        $url = $this->FACEBOOK_GRAPH_API_PREFIX . "/me/groups?fields=administrator,cover,emails,picture,id,name,url,username,access_token,accounts,perms,category&limit=400&access_token={$accessToken}";
        $response = Http::get($url);
        $response = $response->json();

        if (isset($response['error']))
            return [];

        return $response['data'];
    }
}
