<?php


namespace App\Services\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    public function create(RegisterRequest $request): User
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $student = new Student();
        $student->filiere = $request->filiere;
        $student->user_id = $user->id;
        $student->save();


        return $user;
    }


    public function createAccessToken(User $user): \Laravel\Passport\PersonalAccessTokenResult
    {
        $tokenResult = $user->createToken('access Token');
        $token = $tokenResult->token;
        $token->save();

        return $tokenResult;
    }

    public function buildResponse($token , String $message): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message'=>$message,
            'access_token'=>$token->accessToken,
            'token_type'=>'Bearer',
            'expires_at'=>$token->token->expires_at
        ]);
    }
}
