<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ActivityController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('activity-access'), 403);

        $activities = Activity::orderBy('id', 'desc')->get();

        return view('admin.activity.index', compact('activities'));
    }



    public function show(Activity $activity)
    {
        abort_unless(Gate::allows('activity-show'), 403);

        $activity->update(['is_read' => 1]);

        return view('admin.activity.show', compact('activity'));
    }



    public function destroy($id)
    {
        abort_unless(Gate::allows('activity-access'), 403);

        try {
            Activity::where('id', $id)->delete();

            Alert::toast(
                __('gennix.model_activity.alert_messages.destroy_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_activity.alert_messsages.destroy_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_activity.alert_messsages.destroy_error') . ' ID ' . $id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }
    }

    public function showDetails(Activity $activity)
    {
        abort_unless(Gate::allows('activity-show'), 403);

        if (!$activity->is_read) {
            $activity->update(['is_read' => 1]);
        }

        return view('admin.activity.show', compact('activity'));
    }




    public function processRecords($type)
    {
        $ids = $_POST['data'];

        if ($type == 0) {
            $this->changeMassIsRead($ids, true);
        } elseif ($type == 1) {
            $this->changeMassIsRead($ids, false);
        } elseif ($type == 2) {
            $this->deleteMass($ids);
        }
    }



    public function changeMassIsRead($ids, $value)
    {
        try {
            foreach ($ids as $id) {
                Activity::where('id', $id)
                    ->update([
                        'is_read' => $value,
                        'updated_at' => now(),
                    ]);
            }
            if ($value) {
                Alert::toast(
                    __('gennix.model_activity.alert_messages.is_read_success') .
                        __('gennix.model_activity.is_read'),
                    'success'
                )->timerProgressBar();
            } else {
                Alert::toast(
                    __('gennix.model_activity.alert_messages.is_read_success') .
                        __('gennix.model_activity.is_unread'),
                    'success'
                )->timerProgressBar();
            }
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_activity.alert_messages.is_read_error')
            )->autoClose(2000)->timerProgressBar()->width('33rem');

            Auth::user()->saveActivity(
                __('gennix.model_activity.alert_messages.is_read_error') . ' ID ' . $id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }
    }



    public function deleteMass($ids)
    {
        try {
            foreach ($ids as $id) {
                Activity::where('id', $id)->delete();
            }

            Alert::toast(
                __('gennix.model_activity.alert_messages.deletemass_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_activity.alert_messages.deletemass_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_activity.alert_messages.deletemass_error') . ' Last ID ' . $id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }
    }
}
