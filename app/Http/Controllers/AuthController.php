<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $formFields= $request->validate([
            'name'=>'required|string|min:3|max:20',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);
         
        $hash= Hash::make($formFields['password']);
        User::create([
            'name'=> $formFields['name'],
            'email'=>$formFields['email'],
            'password'=>$hash,
        ]);
        
        return response()->json('ajout with succes',201);
    }

    public function login(Request $request){
        $formFields= $request->validate([
            'email' => 'required|email',
            'password'=>'required|min:8',
        ]);
        if(Auth::attempt($formFields)){
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            return response()->json([
                'message' => 'Connexion réussie',
                'user' => $user,
                'token' => $token
            ], 200);
        }
        else{
            return response()->json('les donnes faux');
        }
    }

    public function logout(Request $request)
{
    // Supprimer le token de l'utilisateur authentifié
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => 'Déconnexion réussie !'
    ], 200);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
