<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class PermissionController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('permission-access'), 403);

        $permissions = Permission::all();

        return view('admin.permission.index', compact('permissions'));
    }


    public function create()
    {
        abort_unless(Gate::allows('permission-create'), 403);

        return view('admin.permission.create');
    }


    public function store(PermissionStoreRequest $request)
    {
        abort_unless(Gate::allows('permission-create'), 403);

        try {
            Permission::create($request->all());

            Alert::toast(
                __('gennix.model_permission.alert_messages.store_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_permission.alert_messages.store_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_permission.alert_messages.store_error') . ' Permission: ' . $request->title,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('permission.index');
    }


    public function show(Permission $permission)
    {
        abort_unless(Gate::allows('permission-show'), 403);

        return view('admin.permission.show', compact('permission'));
    }


    public function edit(Permission $permission)
    {
        abort_unless(Gate::allows('permission-edit'), 403);

        return view('admin.permission.edit', compact('permission'));
    }


    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        abort_unless(Gate::allows('permission-edit'), 403);

        try {
            $permission->update($request->all());

            Alert::toast(
                __('gennix.model_permission.alert_messages.update_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_permission.alert_messages.update_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_permission.alert_messages.update_error') . ' ID ' . $request->id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('permission.index');
    }


    public function destroy($id)
    {
        abort_unless(Gate::allows('permission-delete'), 403);

        try {
            $permission = Permission::where('id', $id)->first();
            $permission->delete();

            Alert::toast(
                __('gennix.model_permission.alert_messages.destroy_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_permission.alert_messages.destroy_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_permission.alert_messages.destroy_error') . ' ID ' . $id,
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
