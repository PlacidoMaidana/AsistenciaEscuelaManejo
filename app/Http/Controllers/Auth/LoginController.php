<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Mpociot\FaceAuth\FaceAuthUserProvider;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    protected $userProvider;
    use AuthenticatesUsers;


    // /**
    //  * Handle a login request to the application.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function login(Request $request)
    // {

    //      // Log para verificar si la foto se obtiene correctamente
    //      logger()->info('Foto recibida:', ['photo' => $request->photo]);
    //     // Agregar un registro de actividad para verificar si el método se está ejecutando
    //      logger()->info('Estoy en el LoginController '.$request);
    //     // Personalizar la lógica de autenticación aquí
    // }



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    // public function login(Request $request)
    // {
    //     $userProvider = app(FaceAuthUserProvider::class);
    //     $credentials = $request->only('email', 'password');

    //     // Validar las credenciales y la foto del usuario
    //     // if ($this->attemptLogin($credentials)) {
    //     //     return redirect()->intended('/dashboard');
    //     // }

    //     // Autenticación fallida
    //     return redirect()->back()->withErrors(['photo' => 'La foto no coincide']);
    // }

    // protected function attemptLogin(array $credentials)
    // {
    //     // Obtener el usuario por correo electrónico
    //     $user = $this->userProvider->retrieveByCredentials($credentials);
    //     // Validar la foto del usuario
    //     if ($user && $this->userProvider->validateCredentials($user, $credentials)) {
    //         //Auth::login($user);
    //         return true;
    //     }
    //     return false;
    // }


    // public function login(Request $request)
    // {
    //      // Obtener todos los datos de la solicitud
    //      $requestData = $request->all();

    //      // Obtener el correo electrónico y la contraseña de la solicitud
    //      $email = $request->input('email');
    //      $password = $request->input('password');
 
    //      // Log para verificar los datos de la solicitud
    //      logger()->info('Datos de la solicitud:'. json_encode($requestData));       
    //      logger()->info('Correo electrónico:'. $email);
    //      logger()->info('Contraseña:'. $password);
        
    //      die;
        
    //     $credentials = $request->only('email', 'password');
    
    //     // Validar las credenciales y la foto del usuario
    //     if ($this->attemptLogin($credentials)) {
    //         return redirect()->intended('/dashboard');
    //     }
    
    //     // Autenticación fallida
    //     Log::info('La foto del usuario no coincide', ['email' => $credentials['email']]);
    //     return redirect()->back()->withErrors(['photo' => 'La foto no coincide']);
    // }


}
