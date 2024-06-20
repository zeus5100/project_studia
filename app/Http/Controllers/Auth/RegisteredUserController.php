<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string|min:4|max:255|unique:users,login',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'selected_role' => 'required|integer',
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'phone' => 'required_if:selected_role,1|nullable|string|max:20',
            'class_id' => 'required_if:selected_role,2|nullable|exists:student_classes,id',
            'comments' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'login' => $request->login,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->attach($request->selected_role);
            if ($request->selected_role == 1) {
                $user->teacher()->create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'comments' => $request->comments,
                ]);
            }

            if ($request->selected_role == 2) {
                $user->student()->create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'comments' => $request->comments,
                    'student_class_id' => $request->class_id,
                ]);
            }
        });
    }
}
