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
use PdfReport;
use ExcelReport;
use CSVReport;

class RoleController extends Controller
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
        abort_unless(Gate::allows('role-access'), 403);

        $roles = Role::all();

        return view('admin.role.index', compact('roles'));
    }


    /**
     * ====================================================================
     * Show the form for creating a new resource.
     * ====================================================================
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('role-create'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.role.create', compact('permissions'));
    }


    /**
     * ====================================================================
     * Store a newly created resource in storage.
     * ====================================================================
     *
     * @param  \App\Http\Requests\RoleStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        abort_unless(Gate::allows('role-create'), 403);

        try {
            $role = Role::create($request->all());
            $role->permissions()->sync($request->input('permissions'));

            Alert::toast(
                __('gennix.model_role.alert_messages.store_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_role.alert_messages.store_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_role.alert_messages.store_error') . ' Permission: ' . $request->title,
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


    /**
     * ====================================================================
     * Display the specified resource.
     * ====================================================================
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        abort_unless(Gate::allows('role-show'), 403);

        return view('admin.role.show', compact('role'));
    }


    /**
     * ====================================================================
     * Show the form for editing the specified resource.
     * ====================================================================
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        abort_unless(Gate::allows('role-edit'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.role.edit', compact('permissions', 'role'));
    }


    /**
     * ====================================================================
     * Update the specified resource in storage.
     * ====================================================================
     *
     * @param \App\Http\Requests\RoleUpdateRequest $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        abort_unless(Gate::allows('role-edit'), 403);

        try {
            $role->update($request->all());
            $role->permissions()->sync($request->input('permissions'));

            Alert::toast(
                __('gennix.model_role.alert_messages.update_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_role.alert_messages.update_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_role.alert_messages.update_error') . ' ID ' . $request->id,
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


    /**
     * ====================================================================
     * Remove the specified resource from storage.
     * ====================================================================
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('role-delete'), 403);

        try {
            $role = Role::where('id', $id)->first();

            $role->detachAllPermissions();
            $role->delete();

            Alert::toast(
                __('gennix.model_role.alert_messages.destroy_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_role.alert_messages.destroy_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_role.alert_messages.destroy_error') . ' ID ' . $id,
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


    /**
     * ====================================================================
     * Clone a specific role.
     * ====================================================================
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

            Alert::toast(
                __('gennix.model_role.alert_messages.clone_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_role.alert_messages.clone_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_role.alert_messages.clone_error') . ' ID ' . $id,
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


    /**
     * ====================================================================
     * Export data to excel file
     *
     * @param string $type
     *
     * @return void
     * ====================================================================
     */
    public function export(string $type)
    {
        $role = Role::orderBy('id', 'asc');

        $title = "Relação de Papéis do Sistema";

        $meta = [
            'Ordem' => 'por ID',
        ];

        $columns = [
            'ID' => 'id',
            'Nome do Papel' => 'title',
            'Permissões' => function ($result) {
                $list = '';
                foreach ($result->permissions as $permission) {
                    if ($result->permissions->last() == $permission) {
                        $list .= $permission->title;
                    } else {
                        $list .= $permission->title . ', ';
                    }
                }
                return $list;
            },
            'Usuários' => function ($result) {
                $list = '';
                foreach ($result->users as $user) {
                    if ($result->users->last() == $user) {
                        $list .= $user->name;
                    } else {
                        $list .= $user->name . ', ';
                    }
                }
                return $list;
            }

        ];

        if ($type == "pdf") {
            return $this->exportPDF($role, $title, $meta, $columns);
        } elseif ($type == "xlsx") {
            return $this->exportExcel($role, $title, $meta, $columns);
        } else {
            return $this->exportCSV($role, $title, $meta, $columns);
        }
    }


    /**
     * ====================================================================
     * Export report to PDF format
     *
     * @param App\Role $role
     * @param string $title
     * @param array $meta
     * @param array $columns
     *
     * @return PdfReport
     * ====================================================================
     */
    public function exportPDF($role, $title = "", $meta = [], $columns)
    {
        return PdfReport::of($title, $meta, $role, $columns)
            ->editColumn('ID', ['class' => 'center col-id'])
            ->editColumn('Nome do Papel', ['class' => 'left col-role-name'])
            ->editColumn('Permissões', ['class' => 'left col-permission'])
            ->editColumn('Usuários', ['class' => 'left col-user-name'])
            ->setCss([
                '.col-id'         => 'vertical-align:top;',
                '.col-role-name'  => 'vertical-align:top; max-width:100px',
                '.col-permission' => 'vertical-align:top; max-width:200px; word-warp:break-word',
                '.col-user-name'  => 'vertical-align:top; max-width:90px; word-warp:break-word',
            ])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->showNumColumn(false)
            ->stream();
    }


    /**
     * ====================================================================
     * Export report to Excel format
     *
     * @param App\Role $role
     * @param string $title
     * @param array $meta
     * @param array $columns
     *
     * @return ExcelReport
     * ====================================================================
     */
    public function exportExcel($role, $title = "", $meta = [], $columns)
    {
        return ExcelReport::of($title, $meta, $role, $columns)
            ->showNumColumn(false)
            ->showMeta(false)
            ->download('roles');
    }


    /**
     * ====================================================================
     * Export report to CSV format
     *
     * @param App\Role $role
     * @param string $title
     * @param array $meta
     * @param array $columns
     *
     * @return CSVReport
     * ====================================================================
     */
    public function exportCSV($role, $title = "", $meta = [], $columns)
    {
        return CSVReport::of($title, $meta, $role, $columns)
            ->showNumColumn(false)
            ->showMeta(false)
            ->download('roles');
    }
}
