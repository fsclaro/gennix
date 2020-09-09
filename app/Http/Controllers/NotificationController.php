<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;
use App\User;

class NotificationController extends Controller
{
    /**
     * ====================================================================
     * Display a listing of the resource.
     * ====================================================================
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('notification-access'), 403);

        if (Auth::user()->is_superadmin) {
            $notifications = Notification::all();
        } else {
            $notifications = Notification::where('user_id_to', Auth::user()->id)->get();
        }

        return view('admin.notification.index', compact('notifications'));
    }


    /**
     * ====================================================================
     * Display the specified resource.
     * ====================================================================
     *
     * @param  \App\Notification $notification
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        abort_unless(Gate::allows('notification-show'), 403);

        // Se a notificação é para você e ainda não foi lida, então atualiza o atributo is_read
        if ($notification->user_id_to == Auth::user()->id && ! $notification->is_read) {
            Notification::where('id', $notification->id)
                ->update([ 'is_read' => true ]);
        }

        return view('admin.notification.show', compact('notification'));
    }
}
