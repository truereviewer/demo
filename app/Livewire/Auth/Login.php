<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class Login extends Component
{
    #[Locked]
    public string $name = 'test user';

    #[Locked]
    public string $email = 'testuser@mail.com';

    #[Locked]
    public string $password = 'password';

    public bool $rememberMe = false;

    public function login(Request $request): Redirector
    {
        $request->session()->regenerate();

        $user = User::query()
            ->createOrFirst(
                [
                    'email' => 'testuser@mail.com',
                ],
                [
                    'name' => 'test user',
                    'email' => 'testuser@mail.com',
                    'password' => Hash::make('password'),
                ]
            );

        Auth::login($user, $this->rememberMe);

        return redirect()->intended();
    }

    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
