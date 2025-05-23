<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nif' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', 'string', function ($attribute, $value, $fail) {
                $response = $value;
                $secret = env('RECAPTCHA_SECRET_KEY');
                $remoteip = request()->ip();

                $client = new \GuzzleHttp\Client(['verify' => false]);
                $res = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                    'form_params' => [
                        'secret' => $secret,
                        'response' => $response,
                        'remoteip' => $remoteip,
                    ],
                ]);

                $body = json_decode((string) $res->getBody());

                if (! $body->success) {
                    $fail('The reCAPTCHA verification failed. Please try again.');
                }
            }],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nif' => $request->nif,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
