<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'phone'          => 'required|string|max:20',
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:8|confirmed', // precisa de password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors'  => $validator->errors()
            ], 422);
        }

        try{
            // Verificar se a empresa já existe
            $existingCompany = Company::where('cpf_cnpj', $request->cpf_cnpj)->first();
            if ($existingCompany) {
                return response()->json([
                    'message' => 'Empresa com este CPF/CNPJ já existe.'
                ], 409);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao verificar empresa existente.',
                'error'   => $e->getMessage()
            ], 500);
        }
        try{
            // Verificar se o email já existe
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'message' => 'Usuário com este email já existe.'
                ], 409);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao verificar usuário existente.',
                'error'   => $e->getMessage()
            ], 500);
        }
        try{
            DB::beginTransaction();
            // Criar empresa
            $company = Company::create([
                'name'      => $request->name,
                'phone'     => $request->phone,
                'slug'      => Str::slug($request->ame),
            ]);

            // Criar usuário
            $user = User::create([
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'company_id'    => $company->id,
            ]);

            // Gerar token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user'          => $user,
                'token'         => $token,
                'message'       => 'Usuário registrado com sucesso.',
                'company'       => $company,
                'token_type'    => 'Bearer'
            ], 201);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao registrar usuário.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['status' => 'error', 'message' => 'Credenciais inválidas'], 401);
            }
            $user = Auth::user();
            $company = $user->company;
            $token = $user->createToken('token')->plainTextToken;
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Erro ao realizar login'], 500);
        }


        return response()->json(['company' => $company, 'user' => $user, 'token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado']);
    }
}

