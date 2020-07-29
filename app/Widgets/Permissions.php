<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Permission;

class Permissions extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $countPermissions = Permission::count();

        $this->config = [
            'title' => __('gennix.widgets.permissions'),
            'count' => $countPermissions,
        ];

        return view('widgets.permissions', [
            'config' => $this->config,
        ]);
    }
}
