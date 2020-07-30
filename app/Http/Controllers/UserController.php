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
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('user-access'), 403);

        $users = User::all();

        return view('admin.user.index', compact('users'));
    }



    public function create()
    {
        abort_unless(Gate::allows('user-create'), 403);

        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }



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
                __('gennix.model_user.alert_messsages.store_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.store_error') . ' User: ' . $request->name,
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



    public function show(User $user)
    {
        abort_unless(Gate::allows('user-show'), 403);

        return view('admin.user.show', compact('user'));
    }



    public function edit(User $user)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.user.edit', compact('user', 'roles'));
    }



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
                __('gennix.model_user.alert_messsages.update_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.update_error') . ' ID: ' . $request->id,
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
                __('gennix.model_user.alert_messsages.destroy_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.destroy_error') . ' ID: ' . $user->id,
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


    public function profile()
    {
        abort_unless(Gate::allows('user-profile'), 403);

        $user = Auth::user();

        return view('admin.user.profile', compact('user'));
    }



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
                __('gennix.model_user.alert_messsages.profile_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.profile_error') . ' ID: ' . $request->id,
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
                __('gennix.model_user.alert_messsages.active_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.active_error') . ' ID: ' . $id,
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
                __('gennix.model_user.alert_messsages.deactive_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.deactive_error') . ' ID: ' . $->id,
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
                    __('gennix.model_user.alert_messsages.avatar_error')
                )->autoClose(2000)->timerProgressBar();

                Auth::user()->saveActivity(
                    __('gennix.model_user.alert_messsages.avatar_error') . ' ID: ' . $request->id,
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

    public function changePassword($id)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $user = User::find($id);

        return view('admin.user.password', compact('user'));
    }


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
                __('gennix.model_user.alert_messsages.password_error')
            )->autoClose(2000)->timerProgressBar();

            Auth::user()->saveActivity(
                __('gennix.model_user.alert_messsages.password_error') . ' ID: ' . $request->id,
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
}
