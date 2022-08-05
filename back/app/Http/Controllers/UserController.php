<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return User::where('id','!=',1)->get();
    }
    public function login(Request $request){
        if (!Auth::attempt($request->all())){
            return response()->json(['res'=>'No existe el usuario'],400);
        }
        if (User::where('email',$request->email)->whereDate('fechaLimite','>',now())->get()->count()==0){
            return response()->json(['res'=>'Su usuario sobre paso el limite de ingreso'],400);
        }

        $user=User::where('email',$request->email)->firstOrFail();
        $token=$user->createToken('web')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>$user],200);;
    }
    public function register(Request $request){
        $request->validate([
            'email'=>'required|unique:users|email',
            'carnet'=>'required|unique:users',
        ]);
        $user=new User();
        $user->name= strtoupper( $request->name);
        $user->email=$request->email;
        $user->password=Hash::make( $request->password);
        $user->fechaLimite=date('Y-m-d', strtotime(now(). ' + 7 days'));;
        $user->save();
        $permiso = Permiso::find([3]);
        $user->permisos()->attach($permiso);
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>User::where('id',$user->id)->with('permisos')->with('unit')->firstOrFail()],200);;
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
            'tipo' => 'required',
            'fechaLimite' => 'required',
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->tipo=$request->tipo;
        $user->password= Hash::make($request->password) ;
        $user->fechaLimite=$request->fechaLimite;
        $user->save();
    }
    public function update(Request $request,User $user){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'tipo' => 'required',
            'fechaLimite' => 'required',
        ]);
        $user->update($request->all());
        return $user;
    }

    public function updatePassword(Request $request,User $user){
        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        $user->update([
            'password'=>Hash::make($request->password)
        ]);
        return $user;
    }
    public function destroy(User $user){
        $user->delete();
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['res'=>'salido exitosamente'],200);
    }
    public function me(Request $request){
        $user=User::where('id',$request->user()->id)->firstOrFail();
        return $user;
    }
}
