<?php

namespace App\Exports;

use App\Permission;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PermissionsExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('admin.permission.export', [
            'permissions' => Permission::all()
        ]);
    }
}
