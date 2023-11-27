<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->all();
            $validate = Validator::make($data, [
                "name" => "required",
                "username" => "required",
                "password" => "required",
                "role" => "required",
            ]);
            if ($validate->fails()) {
                $response = [
                    'errors' => $validate->errors()
                ];

                return ResponseFormatter::error($response, 'Bad Request', 400);
            }
            $userData = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'role' => $data['role'],
            ]);

            if ($data['role'] == 'student') {
                $evaluationData = Evaluation::create([
                    'user_id' => $userData->id,
                ]);
            }



            return ResponseFormatter::success("Succeed Register Data.");
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('username', 'password');
            $validate = Validator::make(
                $credentials,
                [
                    'username' => 'required',
                    'password' => 'required',
                ]
            );
            if ($validate->fails()) {
                $response = [
                    'errors' => $validate->errors()
                ];

                return ResponseFormatter::error($response, 'Bad Request', 400);
            }

            if (!Auth::attempt($credentials)) {
                $messages = 'username atau sandi yang Anda masukkan salah';

                throw new Exception($messages, 401);
            }

            $user = User::where('username', $request['username'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            if ($user->role == "administrator") {
                $response = [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ];
                return ResponseFormatter::success($response, 'Authenticated Administrator Success');
            } else {
                $response = [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ];
                return ResponseFormatter::success($response, 'Authenticated Success');
            }
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
}
