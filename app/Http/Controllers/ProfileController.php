<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($request->has('avatar')) {
            $avatarName = $user->id . '_avatar' . time() . '.' . $request->avatar->getClientOriginalExtension();

            $request->avatar->storeAs('img/avatars', $avatarName);

            $user->avatar = $avatarName;
        }

        if ($request->has('password')) {
            if (!Hash::check($request->current_password, $user->password)) {

                return back()->withErrors('Senha errada!');
            } else {

                Validator::make($request->all(), [
                    'password' => 'required|confirmed',
                ])->validate();

                $request->merge([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        $user->update($request->all());

        return back()->with('success', 'Perfil Editado!');
    }

    public function password()
    {
        return view('profile.password');
    }

    public function infos()
    {
        return view('profile.infos');
    }
}
