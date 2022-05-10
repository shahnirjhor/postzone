<?php

namespace App\Http\Controllers;

use App\Models\FacebookUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacebookUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\FacebookUser  $facebookUser
     * @return \Illuminate\Http\Response
     */
    public function show(FacebookUser $facebookUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacebookUser  $facebookUser
     * @return \Illuminate\Http\Response
     */
    public function edit(FacebookUser $facebookUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacebookUser  $facebookUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacebookUser $facebookUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacebookUser  $facebookUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacebookUser $facebookUser)
    {
        DB::beginTransaction();
        try {
            $facebookUser->delete();
            DB::table("facebook_pages")->where('facebook_user_id',$facebookUser->id)->delete();
            DB::commit();
            return redirect()->route('connect-account.index')->with('success', trans('Facebook Account Deleted Successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('connect-account.index')->with('error',$e);
        }
    }
}
