<?php

namespace App\Exports;

use App\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class RolesExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('admin.role.export', [
            'roles' => Role::all()
        ]);
    }
}
