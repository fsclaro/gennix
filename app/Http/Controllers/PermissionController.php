<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
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
            $permission = Permission::create($request->all());

            Alert::toast('Permissão cadastrada com sucesso', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e a permissão não pode ser cadastrada.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha no cadastramento da permissão ' . $request->title,
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

            Alert::toast('Permissão alterada com sucesso.', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e a permissão não pode ser alterada.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha na alteração da permissão com IDD ' . $request->id,
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

           Alert::toast('Permissão excluída com sucesso.', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e a permissão não foi excluída.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha na exclusão da permissão com ID ' . $id,
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
