<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	/**
	 * Show the login form.
	 */
	public function showLoginForm()
	{
		return view('login');
	}

	/**
	 * Handle an authentication attempt.
	 */
	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		$remember = $request->boolean('remember');

		if (Auth::attempt($credentials, $remember)) {
			$request->session()->regenerate();

			// Redirect based on user position - both superadmin and admin go to dashboard
			if (Auth::user()->position === 'superadmin' || Auth::user()->position === 'admin') {
				return redirect()->intended(route('dashboard'));
			} else {
				// Redirect other users to policies list
				return redirect()->route('policies.index');
			}
		}

		return back()->withInput($request->only('email', 'remember'))
					 ->with('error', 'The provided credentials do not match our records.');
	}

	/**
	 * Log the user out.
	 */
	public function logout(Request $request)
	{
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('login');
	}
}
