<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Shared\Infrastructure\Models\User;
use Thehouseofel\Hexagonal\Domain\Exceptions\FeatureUnavailableException;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (config('hexagonal.fake_login_active')) {
            return view('hexagonal::pages.login.fake.index');
        }

        throw new FeatureUnavailableException();
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!config('hexagonal.fake_login_active')) {
            throw new FeatureUnavailableException();
        }

        $params = $request->validate(['email' => 'required']);
        $user = User::query()->where('email', $params['email'])->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'El email existe']);
        }

        Auth::login($user);
        return redirect()->intended('/dashboard'); // Redirige a donde corresponda
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
