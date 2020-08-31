<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromView
{

    use Exportable;

    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function view(): View
    {
        $users = User::all();

        if ($this->type == "xlsx") {
            return view('admin.user.export.xlsx', [ 'users' => $users ]);
        } elseif ($this->type == "csv") {
            return view('admin.user.export.csv', [ 'users' => $users ]);
        }
    }
}
