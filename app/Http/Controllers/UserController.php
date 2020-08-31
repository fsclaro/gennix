<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Requests\UserPasswordRequest;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\UsersExport;
use Throwable;
use PDF;

class UserController extends Controller
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
        abort_unless(Gate::allows('user-access'), 403);

        $users = User::all();

        return view('admin.user.index', compact('users'));
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
        abort_unless(Gate::allows('user-create'), 403);

        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }



    /**
     * ====================================================================
     * Store a newly created resource in storage.
     * ====================================================================
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        abort_unless(Gate::allows('user-create'), 403);

        try {
            $user = User::create($request->all());

            if (!$request->is_superadmin) {
                $user->roles()->sync($request->input('roles', []));
            }
            $this->storeAvatar($request, $user);

            Alert::toast(
                __('gennix.model_user.alert_messages.store_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.store_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.store_error') . ' User: ' . $request->name,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('user.index');
    }



    /**
     * ====================================================================
     * Display the specified resource.
     * ====================================================================
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_unless(Gate::allows('user-show'), 403);

        return view('admin.user.show', compact('user'));
    }



    /**
     * ====================================================================
     * Show the form for editing the specified resource.
     * ====================================================================
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.user.edit', compact('user', 'roles'));
    }



    /**
     * ====================================================================
     * Update the specified resource in storage.
     * ====================================================================
     *
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        try {
            if (strlen($request->password) > 0) {
                $request->request->set('password', Hash::make($request->password));
            } else {
                $request->request->remove('password');
            }

            $user->update($request->all());

            if (!$request->is_superadmin) {
                $user->roles()->sync($request->input('roles', []));
            }
            $this->storeAvatar($request, $user);

            Alert::toast(
                __('gennix.model_user.alert_messages.update_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.update_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.update_error') . ' ID: ' . $request->id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('user.index');
    }



    /**
     * ====================================================================
     * Remove the specified resource from storage.
     * ====================================================================
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_unless(Gate::allows('user-delete'), 403);

        try {
            if (!$user->is_superadmin) {
                $user->detachAllRoles();
            }
            $user->delete();

            Alert::toast(
                __('gennix.model_user.alert_messages.destroy_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.destroy_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.destroy_error') . ' ID: ' . $user->id,
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
     * Show a form with profile user informations
     * ====================================================================
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        abort_unless(Gate::allows('user-profile'), 403);

        $user = Auth::user();

        return view('admin.user.profile', compact('user'));
    }



    /**
     * ====================================================================
     * Update user data profile
     * ====================================================================
     *
     * @param \App\Http\Requests\UserUpdateProfileRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UserUpdateProfileRequest $request, User $user)
    {
        abort_unless(Gate::allows('user-profile'), 403);

        try {
            if (strlen($request->password) > 0) {
                $request->request->set('password', Hash::make($request->password));
            } else {
                $request->request->remove('password');
            }

            $user->update($request->all());

            $this->storeAvatar($request, $user);

            Alert::toast(
                __('gennix.model_user.alert_messages.profile_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.profile_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.profile_error') . ' ID: ' . $request->id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('user.profile');
    }



    /**
     * ====================================================================
     * Change active field from a user to true
     * ====================================================================
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        try {
            User::where('id', $id)->update([
                'active' => true,
                'updated_at' => now()
            ]);

            Alert::toast(
                __('gennix.model_user.alert_messages.active_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.active_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.active_error') . ' ID: ' . $id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('user.index');
    }


    /**
     * ====================================================================
     * Change active field from a user to false
     * ====================================================================
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactive($id)
    {
        try {
            User::where('id', $id)->update([
                'active' => false,
                'updated_at' => now()
            ]);

            Alert::toast(
                __('gennix.model_user.alert_messages.deactive_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.deactive_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.deactive_error') . ' ID: ' . $id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('user.index');
    }


    /**
     * ====================================================================
     * Store a new avatar from any user
     * ====================================================================
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function storeAvatar(Request $request, User $user)
    {
        if (isset($request['avatar'])) {
            try {
                $avatar = $user->getFirstMedia('avatars');
                if ($avatar) {
                    $avatar->delete();
                }
                $avatar = $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

                Alert::toast(
                    __('gennix.model_user.alert_messages.avatar_success'),
                    'success'
                )->timerProgressBar();
            } catch (Throwable $t) {
                Alert::error(
                    __('gennix.opps'),
                    __('gennix.model_user.alert_messages.avatar_error')
                )->autoClose(2000)->timerProgressBar();

                Auth::user()->saveActivity(
                    __('gennix.model_user.alert_messages.avatar_error') . ' ID: ' . $request->id,
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

    /**
     * ====================================================================
     * Show a form that user can change your password
     * ====================================================================
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword($id)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $user = User::find($id);

        return view('admin.user.password', compact('user'));
    }


    /**
     * ====================================================================
     * Update user password
     * ====================================================================
     *
     * @param \App\Http\Requests\UserPasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storePassword(UserPasswordRequest $request)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $password = Hash::make($request->password);

        try {
            User::where('id', $request->id)
                ->update([
                    'password' => $password,
                ]);

            Alert::toast(
                __('gennix.model_user.alert_messages.password_success'),
                'success'
            )->timerProgressBar();
        } catch (Throwable $t) {
            Alert::error(
                __('gennix.opps'),
                __('gennix.model_user.alert_messages.password_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messages.password_error') . ' ID: ' . $request->id,
                [
                    'message' => $t->getMessage(),
                    'code_error' => $t->getCode(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                ],
                'error'
            );
        }

        return redirect()->route('user.index');
    }


    /**
     * ====================================================================
     * Export data to excel file
     * ====================================================================
     */
    public function export(string $type)
    {

        if ($type == "pdf") {
            $this->exportPDF();
        } else {
            $export = new UsersExport($type);

            if ($type == "xlsx") {
                return $export->download('users.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            } elseif ($type == "csv") {
                return $export->download('users.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        }
    }


    public function exportPDF()
    {
        $user = User::all();

        $pdf = PDF::loadView('admin.user.export.pdf', ['users' => $user])
            ->setOptions(
                [
                    'orientation' => 'landscape',
                    'show_warning' => true,
                ]
            );

        return $pdf->download('users.pdf');
    }
}
