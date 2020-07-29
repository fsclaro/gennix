<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\User;

class UsersActives extends AbstractWidget
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
        $count = User::where('active', true)->count();

        $this->config = [
            'title' => __('gennix.widgets.users_actives'),
            'count' => $count,
        ];

        return view('widgets.users_actives', [
            'config' => $this->config,
        ]);
    }
}
