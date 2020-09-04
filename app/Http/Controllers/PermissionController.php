<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;
use PdfReport;
use ExcelReport;
use CSVReport;

class PermissionController extends Controller
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
        abort_unless(Gate::allows('permission-access'), 403);

        $permissions = Permission::all();

        return view('admin.permission.index', compact('permissions'));
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
        abort_unless(Gate::allows('permission-create'), 403);

        return view('admin.permission.create');
    }


    /**
     * ====================================================================
     * Store a newly created resource in storage.
     * ====================================================================
     *
     * @param  \App\Http\Requests\PermissionStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
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


    /**
     * ====================================================================
     * Display the specified resource.
     * ====================================================================
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        abort_unless(Gate::allows('permission-show'), 403);

        return view('admin.permission.show', compact('permission'));
    }


    /**
     * ====================================================================
     * Show the form for editing the specified resource.
     * ====================================================================
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_unless(Gate::allows('permission-edit'), 403);

        return view('admin.permission.edit', compact('permission'));
    }


    /**
     * ====================================================================
     * Update the specified resource in storage.
     * ====================================================================
     *
     * @param \App\Http\Requests\PermissionUpdateRequest $request
     * @param \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
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
        $permission = Permission::orderBy('id', 'asc');

        $title = "Relação de Permissões do Sistema";

        $meta = [
            'Ordem' => 'por ID',
        ];

        $columns = [
            'ID' => 'id',
            'Descrição da Permissão' => 'title',
            'Slug/Chave' => 'slug',
            'Papéis' => function($result) {
                $list = '';
                foreach($result->roles as $role) {
                    if ($result->roles->last() == $role) {
                        $list .= $role->title;
                    } else {
                        $list .= $role->title . ', ';
                    }
                }
                return $list;

            },
        ];

        if ($type == "pdf") {
            return $this->exportPDF($permission, $title, $meta, $columns);
        } elseif ($type == "xlsx") {
            return $this->exportExcel($permission, $title, $meta, $columns);
        } else {
            return $this->exportCSV($permission, $title, $meta, $columns);
        }
    }


    /**
     * ====================================================================
     * Export report to PDF format
     *
     * @param App\Permission $permission
     * @param string $title
     * @param array $meta
     * @param array $columns
     *
     * @return PdfReport $report
     * ====================================================================
     */
    public function exportPDF($permission, $title = "", $meta = [], $columns)
    {
        return PdfReport::of($title, $meta, $permission, $columns)
            ->editColumn('ID', ['class' => 'center col-id'])
            ->editColumn('Descrição da Permissão', ['class' => 'left col-permission'])
            ->editColumn('Slug/Chave', ['class' => 'left col-slug'])
            ->editColumn('Papéis', ['class' => 'left col-roles'])
            ->setCSS([
                '.col-id' => 'vertical-align: top',
                '.col-permission' => 'vertical-align: top',
                '.col-slug' => 'vertical-align: top',
                '.col-roles' => 'vertical-align:top; word-warp:break-word',
            ])
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->showNumColumn(false)
            ->stream();
    }


    /**
     * ====================================================================
     * Export report to Excel format
     *
     * @param App\Permission $permission
     * @param string $title
     * @param array $meta
     * @param array $columns
     *
     * @return ExcelReport $report
     * ====================================================================
     */
    public function exportExcel($permission, $title = "", $meta = [], $columns)
    {
        return ExcelReport::of($title, $meta, $permission, $columns)
            ->showNumColumn(false)
            ->showMeta(false)
            ->download('permissions');
    }


    /**
     * ====================================================================
     * Export report to CSV format
     *
     * @param App\Permission $permission
     * @param string $title
     * @param array $meta
     * @param array $columns
     *
     * @return CSVReport $report
     * ====================================================================
     */
    public function exportCSV($permission, $title = "", $meta = [], $columns)
    {
        return CSVReport::of($title, $meta, $permission, $columns)
            ->showNumColumn(false)
            ->showMeta(false)
            ->download('permission');
    }
}
