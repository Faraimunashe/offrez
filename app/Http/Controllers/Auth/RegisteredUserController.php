<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Landloard;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'string', 'max:15'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:6'],
            'phone' => ['required', 'string', 'starts_with:07', 'digits:10'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->fname.' '.$request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($request->role == "landlord")
        {
            $landlord = new Landloard();
            $landlord->user_id = $user->id;
            $landlord->fname = $request->fname;
            $landlord->lname = $request->lname;
            $landlord->gender = $request->gender;
            $landlord->phone = $request->phone;
            $landlord->save();
        }elseif($request->role == "student")
        {
            $student = new Student();
            $student->user_id = $user->id;
            $student->fname = $request->fname;
            $student->lname = $request->lname;
            $student->gender = $request->gender;
            $student->phone = $request->phone;
            $student->save();
        }

        $user->addRole($request->role);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
