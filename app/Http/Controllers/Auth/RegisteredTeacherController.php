<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredTeacherController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Teacher/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:'.Teacher::class,
            'login' => 'required|string|max:255|unique:'.Teacher::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'comments' => 'nullable|string|max:255',
        ]);
        $teacher = Teacher::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'comments' => $request->comments,
        ]);

        event(new Registered($teacher));

        Auth::login($teacher);

        return redirect(route('dashboard', absolute: false));
    }
}
