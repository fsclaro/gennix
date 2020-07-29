<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class RoleController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('role-access'), 403);

        $roles = Role::all();

        return view('admin.role.index', compact('roles'));
    }


    public function create()
    {
        abort_unless(Gate::allows('role-create'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.role.create', compact('permissions'));
    }


    public function store(RoleStoreRequest $request)
    {
        abort_unless(Gate::allows('role-create'), 403);

        try {
            $role = Role::create($request->all());
            $role->permissions()->sync($request->input('permissions'));

            Alert::toast('O papel foi cadastrado com sucesso.', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e o papel não foi cadastrado.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha no cadastramento do papel ' . $request->title,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('role.index');
    }


    public function show(Role $role)
    {
        abort_unless(Gate::allows('role-show'), 403);

        return view('admin.role.show', compact('role'));
    }


    public function edit(Role $role)
    {
        abort_unless(Gate::allows('role-edit'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.role.edit', compact('permissions', 'role'));
    }


    public function update(RoleUpdateRequest $request, Role $role)
    {
        abort_unless(Gate::allows('role-edit'), 403);

        try {
            $role->update($request->all());
            $role->permissions()->sync($request->input('permissions'));

            Alert::toast('O papel foi alterado com sucesso.', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e o papel não foi alterado.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha na alteração do papel ' . $request->title,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('role.index');
    }


    public function destroy($id)
    {
        abort_unless(Gate::allows('role-delete'), 403);

        try {
            $role = Role::where('id', $id)->first();

            $role->detachAllPermissions();
            $role->delete();

            Alert::toast('O papel foi excluído com sucesso.', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e o papel não foi excluído.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha na exclusão do papel ' . $id,
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


    public function cloneRole($id)
    {
        abort_unless(Gate::allows('role-create'), 403);

        try {
            $role = Role::find($id);

            foreach ($role->permissions as $permission) {
                $clonedPermissions[] = [
                    'permission_id' => $permission->id,
                ];
            }

            $newRoleID = Role::insertGetId([
                'title' => $role->title,
                'created_at' => now(),
            ]);

            $newRole = Role::find($newRoleID);

            $newRole->permissions()->sync($clonedPermissions);

            Alert::toast('O papel foi clonado com sucesso.', 'success')->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error('Ops!!', 'Ocorreu um erro e o papel não foi clonado.')->autoClose(2000)->timerProgressBar();
            Auth::user()->saveActivity(
                'Falha na clonagem do papel ' . $role->title,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('role.index');
    }
}
