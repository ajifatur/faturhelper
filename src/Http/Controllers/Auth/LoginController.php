<?php

namespace Ajifatur\FaturHelper\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Ajifatur\FaturHelper\Models\User;
use Ajifatur\FaturHelper\Models\UserAccount;

class LoginController extends \App\Http\Controllers\Controller
{
    /**
     * The role key.
     *
     * @var string
     */
    protected $role = 'admin';

    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // View
        return view(custom_view('auth/login'));
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Return if has errors
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Check login type
            $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
            // Set credentials
            $credentials = [
                $loginType => $request->username,
                'password' => $request->password
            ];

            // Auth attempt
            if(Auth::attempt($credentials)) {
                // Regenerate session
                $request->session()->regenerate();

                // Update user's last visit
                $user = User::find($request->user()->id);
                if($user) {
                    $user->last_visit = date('Y-m-d H:i:s');
                    $user->save();
                }

                // Redirect
                if($request->user()->role->is_admin == 1)
                    return redirect()->route('admin.dashboard');
                else
                    return redirect('/');
            }
            else {
                return redirect()->back()->withErrors([
                    'message' => 'Tidak ada akun yang cocok dengan username / password yang Anda masukkan!'
                ])->withInput();
            }
        }
    }
    
    /**
     * Redirect to provider.
     *
     * @param  string $provider
     * @return \Laravel\Socialite\Facades\Socialite
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @param  string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect()->route('admin.dashboard');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  object $user
     * @param  string $provider
     * @return \Ajifatur\FaturHelper\Models\User
     */
    public function findOrCreateUser($user, $provider)
    {
        // Get the user account by provider ID and provider name
        $authUser = UserAccount::where('provider_id','=',$user->getId())->where('provider_name','=',$provider)->first();

        if($authUser) {
            return $authUser;
        }
        else {
            // Get the user by the email
            $data = User::where('email','=',$user->getEmail())->first();

            if(!$data) {
				// Save the user
                $data = new User;
                $data->role_id = role($this->role);
                $data->name = $user->getName();
                $data->username = $user->getNickname();
                $data->email = $user->getEmail();
                $data->password = null;
                $data->access_token = access_token();
                $data->remember_token = null;
				$data->avatar = $user->getAvatar();
				$data->status = 1;
				$data->last_visit = null;
				$data->email_verified_at = null;
                $data->save();
            }
				
            // Save the user account
            $user_account = new UserAccount;
            $user_account->user_id = $data->id;
            $user_account->provider_id = $user->getId();
            $user_account->provider_name = $provider;
            $user_account->save();

            return $data;
        }
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect
        return redirect()->route('auth.login');
    }
}