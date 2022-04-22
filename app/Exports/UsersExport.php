<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    protected $users;

    public function __construct(Request $request)
    {
        $query = User::query();
        $companyDateFormat = "d M Y";
        $this->users = $query->get();
        $this->companyDateFormat = $companyDateFormat;
    }

    public function view(): View
    {
        return view('exports.users', [
            'users' => $this->users,
            'companyDateFormat' => $this->companyDateFormat,
        ]);
    }
}
