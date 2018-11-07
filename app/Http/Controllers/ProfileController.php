<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        if($request->has('avatar'))
        {
            $avatarName = $user->id . '_avatar' . time() . '.' . $request->avatar->getClientOriginalExtension();
            
            $request->avatar->storeAs('img/avatars', $avatarName);

            $user->avatar = $avatarName;
        }

        if($request->has('password'))
        {
            if(!Hash::check($request->current_password, $user->password)) {
            
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        return view('profile.infos');
    }
    
    public function password()
    {
        return view('profile.password');
    }
}
