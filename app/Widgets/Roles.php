<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Role;

class Roles extends AbstractWidget
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
        $countRoles = Role::count();

        $this->config = [
            'title' => __('gennix.widgets.roles'),
            'count' => $countRoles,
        ];

        return view('widgets.roles', [
            'config' => $this->config,
        ]);
    }
}
