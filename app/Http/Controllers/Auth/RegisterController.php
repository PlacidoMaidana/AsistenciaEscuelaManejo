<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       

        // Crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);


        // Obtener la imagen del formulario de registro
        //$photo = request()->file('photo');
        // Obtener los datos base64 de la imagen del formulario de registro
        $imageData = $data['capturedImageDataInput'];


        // Log para verificar si la foto se obtiene correctamente
        logger()->info('Foto recibida:', ['photo' => $imageData]);
        
        // Decodificar los datos base64 y guardar la imagen en la ubicación adecuada con el nombre de archivo correcto
        if ($imageData) {
            $userId = $user->id; // Obtener el ID del usuario
            $imageData = substr($imageData, strpos($imageData, ",") + 1);
            $imageData = base64_decode($imageData);
            file_put_contents(storage_path('facces') . '/' . $userId . '.png', $imageData);
             // Log para verificar la ruta donde se guarda la foto
             logger()->info('Foto guardada en:', ['path' => storage_path('facces') . $userId . '.png']);
        }

        // Retornar el usuario creado
        return $user;
    }
}
