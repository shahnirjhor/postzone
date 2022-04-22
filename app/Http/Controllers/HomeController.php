<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 * @category Controller
 */
class HomeController extends Controller
{
    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard
     *
     * @access public
     * @return mixed
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function lang(Request $request)
    {
        $authId = Auth::user()->id;
        $locale = $request->language;
        App::setLocale($locale);
        session()->put('locale', $locale);
        $postUpdate = User::where('id', $authId)->update(['locale' => $locale]);
        return redirect()->back();
    }

}
