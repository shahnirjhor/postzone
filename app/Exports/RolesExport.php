<?php

namespace App\Exports;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RolesExport implements FromView
{
    protected $roles;

    public function __construct(Request $request)
    {
        $query = Role::query();
        $this->roles = $query->get();
    }

    public function view(): View
    {
        return view('exports.roles', [
            'roles' => $this->roles
        ]);
    }
}
