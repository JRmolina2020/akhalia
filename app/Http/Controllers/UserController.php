<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = DB::table('users AS u')
            ->join('roles AS r', 'u.role_id', '=', 'r.id')
            ->select('u.id', 'u.name', 'u.surname', 'u.email', 'u.status', 'r.name as role', 'r.id as role_id')
            ->orderBy('id', 'desc')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'role_id' => $request['role_id'],
            'password' => bcrypt($request['password']),
        ]);
        $user->save();
        return response()->json(['message' => 'Usuario creado correctamente'], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }

        $user->fill([
            'name' => request('name'),
            'surname' => request('surname'),
            'email' => request('email'),
            'role_id' => $request['role_id'],
            'password' => bcrypt($request['password']),
        ])->save();
        return response()->json(compact('user'), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }
        $user->delete();
        return response()->json(["message" => "Ha sido eliminado"]);
    }
    public function available($id)
    {
        $user = User::findOrFail($id);
        $user->status = '1';
        $user->save();
        return response()->json(["message" => "El usuario ha sido activado"]);
    }
    public function locked($id)
    {
        $user = User::findOrFail($id);
        $user->status = '0';
        $user->save();
        return response()->json(["message" => "El usuario ha sido Bloqueado"]);
    }
    function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return response()->json('wellcome', 200);
        } else {
            return response()->json('Verifique sus credenciales de usuario.', 422);
        }
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}