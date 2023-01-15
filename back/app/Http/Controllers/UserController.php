<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $validated['email'])->with('shop')->first();
        if($user){
            if(Hash::check($validated['password'], $user->password)){
                $token = $user->createToken('token')->plainTextToken;
                $shops = Shop::where('user_id', $user->id)->get();
                return response()->json([
                    'token' => $token,
                    'user' => $user,
                    'shops' => $shops
                ]);
            }else{
                return response()->json([
                    'message' => 'Contraseña incorrecta'
                ], 401);
            }
        }else{
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }
    public function register(Request $request){
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'nameShop' => 'required',
            'type' => 'required',
        ]);
        $shop = Shop::create([
            'name' => $request->nameShop,
            'type' => $request->type,
            'status' => 'active'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $validated['shop_id'] = $shop->id;
        $user = User::create($validated);
        $shop->user_id = $user->id;
        $shop->save();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => User::where('id', $user->id)->with('shop')->first()
        ]);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Sesión cerrada'
        ]);
    }
    public function me(Request $request){
        $shops = Shop::where('user_id', $request->user()->id)->get();
        $user = User::where('id', $request->user()->id)->with('shop')->first();
        return response()->json([
            'user' => $user,
            'shops' => $shops
        ]);
    }
    public function index(Request $request){
    }
    public function show(Request $request, $id){
    }
    public function update(Request $request, User $user){
        return $user->update($request->all());
    }
}
