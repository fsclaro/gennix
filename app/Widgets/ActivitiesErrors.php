<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Activity;

class ActivitiesErrors extends AbstractWidget
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
        $countActivities = Activity::where('type', 'error')
            ->where('is_read', false)
            ->count();

        $this->config = [
            'title' => __('gennix.widgets.errors'),
            'count' => $countActivities,
        ];

        return view('widgets.activities_errors', [
            'config' => $this->config,
        ]);
    }
}
