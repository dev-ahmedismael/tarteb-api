<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(LoginRequest $request) {
        $creds = $request->validated();

        if (! $token = auth()->attempt($creds)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة.'], 401);
        }

        $user = auth()->user();

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'تم تسجيل الدخول بنجاح.'
        ]);
    }

    public function me() {
        $user = auth()->user();

        return response()->json(['user' => $user]);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return response()->json(['user' => $user, 'message' => 'تم تعديل بيانات الملف الشخصي بنجاح.']);
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();

        if (!Hash::check($validated['old_password'], $user->password)) {
            return response()->json(['message' => 'كلمة المرور الحالية غير صحيحة.'], 422);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح.']);
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح.']);
    }
}
