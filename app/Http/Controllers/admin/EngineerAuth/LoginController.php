<?php
    namespace App\Http\Controllers\admin\EngineerAuth;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\EngineerLoginRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller
    {
        public function showLoginForm()
        {
            if (Auth::guard('engineer')->check()) {
                return redirect()->route('admin.engineer.tasks');
            }

            return view('admin.engineers.auth.login');
        }

        public function login(EngineerLoginRequest $request)
        {
            $credentials = $request->validated();

            if (Auth::guard('engineer')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ], $request->filled('remember'))) {

                $request->session()->regenerate();
                return redirect()->route('admin.engineer.tasks');
            }

            return back()->withErrors([
                'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
            ])->onlyInput('email');
        }

        public function logout(Request $request)
        {
            Auth::guard('engineer')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

           return redirect()->route('admin.engineer.login');
        }
    }
