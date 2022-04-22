<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

/**
 * Class UserController
 * @package App\Http\Controllers
 * @category Controller
 */
class UserController extends Controller
{
    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:user-read|user-create|user-update|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-update', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-export', ['only' => ['doExport']]);
    }

    /**
     * Display a listing of the resource
     *
     * @access public
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->export)
            return $this->doExport($request);
        $users = $this->filter($request)->paginate(10)->withQueryString();
        return view('users.index',compact('users'));
    }

    private function filter(Request $request)
    {
        $query = User::orderBy('id','DESC');

        if ($request->id)
            $query->where('id', $request->id);

        if ($request->name)
            $query->where('name', 'like', $request->name.'%');

        if ($request->email)
            $query->where('email', 'like', $request->email.'%');

        return $query;
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new UsersExport($request), 'users.xlsx');
    }

    public function readItemsOutOfStock(User $user)
    {
        foreach ($user->unreadNotifications as $notification) {
            if ($notification->getAttribute('type') != 'App\Notifications\ItemReminder') {
                continue;
            } elseif($notification->getAttribute('type') != 'App\Notifications\Item')
            {
                continue;
            } else {
                $notification->markAsRead();
            }
        }

        return redirect()->route('item.index');
    }

    /**
     * Show the form for creating a new resource
     *
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $staffRoles = Role::where('role_for', '1')->pluck('name','name')->all();
        $userRoles = Role::where('role_for', '0')->pluck('name','name')->all();
        return view('users.create',compact('staffRoles','userRoles'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @access public
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'status' => 'required',
            'role_for' => 'required'
        ]);

        $logoUrl = "";
        if($request->hasFile('photo'))
        {

            $this->validate($request, [
                'photo' => 'image|mimes:png,jpg,jpeg'
            ]);

            $logo = $request->photo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('uploads/employee',$logoNewName);
            $logoUrl = 'uploads/employee/'.$logoNewName;
        }

        if($request->role_for == "1") //staff
        {
            $roles = $request->staff_roles;
        }

        if($request->role_for == "0") //user
        {
            $roles = $request->user_roles;
        }


        $input = array();
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = bcrypt($request->password);
        $input['phone'] = $request->phone;
        $input['address'] = $request->address;
        $input['status'] = $request->status;
        $input['photo'] = $logoUrl;
        $user = User::create($input);
        $user->assignRole($roles);
        return redirect()->route('users.index')->with('success', trans('User Created Successfully'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @access public
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @access public
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roleName = $user->getRoleNames();
        $roleFor = Role::findByName($roleName['0']);

        $staffRoles = Role::where('role_for', '1')->pluck('name','name')->all();
        $userRoles = Role::where('role_for', '0')->pluck('name','name')->all();

        $myUser = $user;

        return view('users.edit',compact('myUser','roleFor','staffRoles', 'userRoles'));
    }

    /**
     * Methot to custom update
     *
     * @access public
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'same:password_confirmation',
            'status' => 'required',
            'role_for' => 'required'
        ]);
        $logoUrl = "";
        if($request->hasFile('photo'))
        {

            $this->validate($request, [
                'photo' => 'image|mimes:png,jpg,jpeg'
            ]);

            $logo = $request->photo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('uploads/employee',$logoNewName);
            $logoUrl = 'uploads/employee/'.$logoNewName;
        }
        $password = $user->password;
        if($request->role_for == "1") //staff
        {
            $roles = $request->staff_roles;
        }
        if($request->role_for == "0") //user
        {
            $roles = $request->user_roles;
        }
        $input = array();
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        if (!empty($request->password))
        {
            $input['password'] = bcrypt($input['password']);
        } else {
            $input['password'] = $password;
        }
        $input['phone'] = $request->phone;
        $input['address'] = $request->address;
        $input['status'] = $request->status;
        $input['photo'] = $logoUrl;
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($roles);
        return redirect()->route('users.index')->with('success', trans('User Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage
     *
     * @param $id
     * @access public
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::table("model_has_roles")->where('model_id',$user->id)->delete();
            DB::table("user_companies")->where('user_id',$user->id)->delete();
            DB::commit();
            return redirect()->route('users.index')->with('success', trans('User Deleted Successfully'));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('error',$e);
        }
    }
}
