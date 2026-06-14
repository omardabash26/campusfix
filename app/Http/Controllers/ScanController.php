<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function show($token)
    {
        $location = Location::where('qr_token', $token)->where('is_active', true)->firstOrFail();

        return view('scan.login', compact('location', 'token'));
    }

    public function verify(Request $request, $token)
    {
        $location = Location::where('qr_token', $token)->firstOrFail();

        $request->validate([
            'identity_number' => 'required|string',
        ], [
            'identity_number.required' => 'נא להזין מספר זהות.',
        ]);

        $user = User::where('identity_number', $request->identity_number)
            ->where('is_active', true)
            ->first();

        if (!$user || !in_array($user->role, ['student', 'lecturer'])) {
            return back()->withErrors(['identity_number' => 'מספר זהות לא נמצא או אינו שייך לסטודנט.'])->onlyInput('identity_number');
        }

        $code = (string) random_int(1000, 9999);

        session([
            'scan_user_id'     => $user->id,
            'scan_location_id' => $location->id,
            'scan_otp'         => $code,
        ]);

        return redirect()->route('scan.otp', $token);
    }

    public function otpForm($token)
    {
        $location = Location::where('qr_token', $token)->firstOrFail();

        if (!session('scan_user_id')) {
            return redirect()->route('scan.show', $token);
        }

        $user = User::find(session('scan_user_id'));

        return view('scan.otp', [
            'location' => $location,
            'token'    => $token,
            'user'     => $user,
            'demoCode' => session('scan_otp'),
        ]);
    }

    public function otpVerify(Request $request, $token)
    {
        Location::where('qr_token', $token)->firstOrFail();

        $request->validate([
            'otp' => 'required|string',
        ], [
            'otp.required' => 'נא להזין את הקוד.',
        ]);

        if (!session('scan_user_id') || $request->otp !== session('scan_otp')) {
            return back()->withErrors(['otp' => 'הקוד שגוי.']);
        }

        Auth::loginUsingId(session('scan_user_id'));
        $request->session()->regenerate();
        session()->forget(['scan_user_id', 'scan_otp']);

        return redirect()->route('tickets.create');
    }
}
