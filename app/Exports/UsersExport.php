<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromView
{

    use Exportable;
    
    public function view(): View
    {
        return view('admin.user.export', [
            'users' => User::all()
        ]);
    }
}
