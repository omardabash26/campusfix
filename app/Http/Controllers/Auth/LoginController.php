<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
         if (auth()->check()) {
        return $this->redirectByRole();
    }

    return view('auth.login');
    }

    // Handle login submission
    public function login(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|string',
            'password'        => 'required|string',
        ], [
            'identity_number.required' => 'נא להזין מספר זהות.',
            'password.required'        => 'נא להזין סיסמה.',
        ]);

        $credentials = [
            'identity_number' => $request->identity_number,
            'password'        => $request->password,
            'is_active'       => true,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (in_array(auth()->user()->role, ['student', 'lecturer'])) {
                Auth::logout();
                return back()->withErrors([
                    'identity_number' => 'סטודנטים מדווחים על תקלה דרך סריקת קוד QR.',
                ])->onlyInput('identity_number');
            }

            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'identity_number' => 'מספר הזהות או הסיסמה שגויים.',
        ])->onlyInput('identity_number');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Redirect user based on their role
    private function redirectByRole()
    {
        return match(auth()->user()->role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'technician' => redirect()->route('technician.dashboard'),
            default      => redirect()->route('tickets.index'),
        };
    }
}