<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditStoreRequest;
use App\Http\Requests\AuditUpdateRequest;
use App\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class AuditController extends Controller
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
        abort_unless(Gate::allows('audit-access'), 403);

        $audits = Audit::all();

        return view('admin.audit.index', compact('audits'));
    }




    /**
     * ====================================================================
     * Display the specified resource.
     * ====================================================================
     *
     * @param  \App\Audit ${modelNameSingularLowerCase}}
     * @return \Illuminate\Http\Response
     */
    public function show(Audit $audit)
    {
        abort_unless(Gate::allows('audit-show'), 403);

        $properties = $audit->properties;

        return view('admin.audit.show', compact('audit', 'properties'));
    }
}
