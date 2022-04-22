<?php

namespace App\Http\Controllers;

use App\Models\FacebookApp;
use Illuminate\Http\Request;

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
        $apps = $this->filter($request)->paginate(10)->withQueryString();
        return view('facebook-app.index',compact('apps'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacebookApp  $facebookApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacebookApp $facebookApp)
    {
        //
    }
}
