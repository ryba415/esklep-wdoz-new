<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\globalHelper\globalHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Email;
use Config;

class LoginRegisterController extends Controller
{
/**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        
        $token = bin2hex(random_bytes(18));
        $protocol = 'https://';
        if (!$this->isSecure()){
            $protocol = 'http://';
        }
        $link = $protocol . Config::get('constants.system_domain') . '/activate-email/' . $token;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $dbUserUpdate = DB::update('UPDATE users SET email_confirm_token=? WHERE email=?', 
                            [$token, $request->email]);

        //$credentials = $request->only('email', 'password');
        //Auth::attempt($credentials);
        $request->session()->regenerate();
        
        $emailVariables = [];
        $emailVariables['title'] = 'Dziękujemy za dołączenie do serwisu Legesfera';
        $emailVariables['date'] = date('Y-m-d H:i:s');
        $emailVariables['content'] = 'Aby aktywować swoje konto w serwisie legesfera kliknij w poniższy link: <br> <a href="' . $link . '"> '. $link .'</a>';
        $email = new Email($request->email, 'Dziękujemy za dołączenie do serwisu Legesfera','short-info-mail', $emailVariables);
        $email->send();
        
        $emailVariables = [];
        $emailVariables['title'] = 'Ktoś założył w Legesfera!';
        $emailVariables['date'] = date('Y-m-d H:i:s');
        $emailVariables['content'] = 'Udało się, ktoś założył konto!! ';
        $email = new Email(Config::get('constants.technical_admins_mails'), 'Ktoś założył w Legesfera','short-info-mail', $emailVariables);
        $email->send();

        return back()->with('message', 'Link do aktywacji konta został wysłany na Twój adres e-mail. Sprawdź swoją skrzynkę e-mail i kliknij w link aktywacyjny. '
                    . 'Jeżeli nie możesz znaleźć e-maila aktywacyjnego sprawdź folder spam lub wygeneruj nowy link aktywacyjny: <a href="/resend-activate-email">tutaj</a> ');
            
        //return redirect()->route('dashboard')
        //->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            if (Auth::user()->isActive()){
                $request->session()->regenerate();
                return redirect()->route('/user-acount/dasboard')
                ->withSuccess('You have successfully logged in!');
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Konto w serwisie nie zostało jeszcze aktywowane. Sprawdź swoją skrzynkę e-mail i kilkinij w link aktywacyjny. '
                    . 'Jeżeli nie możesz znaleźć e-maila aktywacyjnego sprawdź folder spam, lub wygeneruj nowy link aktywacyjny: <a href="/resend-activate-email">tutaj</a> ',
                ])->onlyInput('email');
            }
            
            
            
        }

        return back()->withErrors([
            'email' => 'Błędny login i/lub hasło',
        ])->onlyInput('email');

    } 
    
        
    public function resendActivateEmail(){
        $viewData = [];

        return view('auth.resend-activate-email',$viewData);
    }
    
    public function resendActivateEmailSumbmit(Request $request){
        $email = $request->input('email');
        
        $user = DB::select('select id, name, email, reset_password_date FROM users WHERE email=?', [$email]);
        
        if (count($user)> 0){
            
            $emailVariables = [];
            $emailVariables['date'] = date('Y-m-d H:i:s');
            
            
            $token = bin2hex(random_bytes(18));
            $protocol = 'https://';
            if (!$this->isSecure()){
                $protocol = 'http://';
            }
            $link = $protocol . Config::get('constants.system_domain') . '/activate-email/' . $token;
                    
            $dbUserUpdate = DB::update('UPDATE users SET email_confirm_token=? WHERE id=?', 
                            [$token, $user[0]->id]);
            
            $this->sendActivateEmail($link,$user[0]->email);
                    
            return back()->with('message', 'Na wskazany adres e-mail wysłano link do aktywacji konta');
        }  else {
            return back()->withErrors([
                'email' => 'Na wskazany adres e-mail nie zostało jeszcze utworzone konto w systemie',
            ])->onlyInput('email');
        }
    }
    
    public function activateEmail(Request $request, $hash){
        
        $viewData = [];
        
        $user = DB::select('select id, name, email_confirm_token FROM users WHERE email_confirm_token=?', [$hash]);
        
        if (count($user)> 0){

            $dbUserUpdate = DB::update('UPDATE users SET is_active=1, email_verified_at=? WHERE id=?', 
                [date('Y-m-d H:i:s'), $user[0]->id]);

            $viewData['message'] = 'Konto zostało aktywowane. Możesz zalogować się do systemu';
            $viewData['messageType'] = 'positive';
        } else {
            $viewData['messageType'] = 'negative';
            $viewData['message'] = 'Link do aktywacji konta jest niepoprawny lub wygasł.';
        }
        
        return view('auth.activate-email',$viewData);
    }
    
    public function sendActivateEmail($link, $email){
        
        
        $emailVariables = [];
        $emailVariables['title'] = 'Link do aktywacji konta - Legesfera';
        $emailVariables['date'] = date('Y-m-d H:i:s');
        $emailVariables['content'] = 'Aby aktywować swoje konto w serwisie legesfera kliknij w poniższy link: <br> <a href="'.$link.'">'.$link.'</a>' ;
        $email = new Email($email, 'Link do aktywacji konta - Legesfera','short-info-mail', $emailVariables);
        $email->send();

    }
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function dashboard()
    {
        
        if(Auth::check())
        {
            return view('auth.dashboard');
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } */
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    } 
    
    public function resetPassword(Request $request){
        return view('auth.resetpassword');
    }
    
    public function resetPasswordSumbit(Request $request){
        $email = $request->input('email');
        
        $globalHelper = new globalHelper();
        
        $email = $globalHelper->saveDbEmail($email);
        
        $user = DB::select('select id, name, email FROM users WHERE email=?', [$email]);
        
        if (count($user)> 0){
            
            $emailVariables = [];
            $emailVariables['date'] = date('Y-m-d H:i:s');
            
            
            $token = bin2hex(random_bytes(18));
            $protocol = 'https://';
            if (!$this->isSecure()){
                $protocol = 'http://';
            }
            $emailVariables['resetLink'] = $protocol . Config::get('constants.system_domain') . '/set-new-password/' . $token;
                    
            $dbUserUpdate = DB::update('UPDATE users SET reset_password_token=?, reset_password_date=? WHERE id=?', 
                            [$token, date('Y-m-d H:i:s'), $user[0]->id]);
            
            $email = new Email($email, 'Reset hasła - Legesfera','emails.resetpassword', $emailVariables);
            $email->send();
            return back()->with('message', 'Na wskazany adres e-mail wysłano link do resetu hasła');
        } else {
            return back()->withErrors([
                'email' => 'Nie znaleziono użytkownika zarejestrowanego na ten adres e-mail.',
            ])->onlyInput('email');
        }
    }
    
    public function setNewPassword($hash){
        $user = DB::select('select id, name, email, reset_password_token, reset_password_date FROM users WHERE reset_password_token=?', [$hash]);
        
        $viewData = [];
        $viewData['hash'] = $hash;
        return view('auth.set-new-password',$viewData);
    }
    
    public function isSecure() {
        return
          (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
          || $_SERVER['SERVER_PORT'] == 443;
    }
    
    public function changePasswordSumbmit(Request $request){
        $hash = $request->input('hash');
        $password = $request->input('new-password');
        $repeatPassword = $request->input('new-password-repeat');
        
        $user = DB::select('select id, name, email, reset_password_date FROM users WHERE reset_password_token=?', [$hash]);
        
        if (count($user)> 0){
            $date = strtotime(date($user[0]->reset_password_date));
            $dateNow = strtotime(date('Y-m-d H:i:s'));
            if ($dateNow-$date < 6000){
                if ($password != '' && strlen($password) > 7){
                    if ($password === $repeatPassword){
                        $dbUserUpdate = DB::update('UPDATE users SET password=?, reset_password_date=? WHERE id=?', 
                            [Hash::make($password), null, $user[0]->id]);
                        
                        return back()->with('message', 'Hasło zostało zmienione poprawnie');
                    } else {
                        return back()->withErrors([
                         'new-password' => 'Podane hasła są różne',
                         ])->onlyInput('new-password'); 
                    }
                } else {
                   return back()->withErrors([
                    'new-password' => 'Hasło musi mieć conajmniej 8 znaków',
                    ])->onlyInput('new-password'); 
                }
            } else {
                return back()->withErrors([
                'new-password' => 'Link do resetu hasła został już wykożystany, lub wygasł',
                ])->onlyInput('new-password');
            }
        } else {
            return back()->withErrors([
                'new-password' => 'Link do resetu hasła jest niepoprawny',
            ])->onlyInput('new-password');
        }
    }
}
