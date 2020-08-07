<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
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
        abort_unless(Gate::allows('contacts-access'), 403);

        $contacts = User::where('active', true)->get();

        return view('admin.contact.index', compact('contacts'));
    }

    /**
     * ====================================================================
     * Display the specified resource.
     * ====================================================================
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(Gate::allows('contacts-access'), 403);

        $user = User::find($id);

        return view('admin.contact.show', compact('user'));
    }
}
