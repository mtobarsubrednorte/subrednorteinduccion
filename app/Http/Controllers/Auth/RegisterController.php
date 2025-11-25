<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Activity;
use App\Models\Profile;



class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $profiles = Profile::all();
        return view('auth.register', compact('profiles'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'document_number' => ['required', 'string', 'max:20', 'unique:users'],
            'document_type'   => ['required', 'string', 'max:50'],
            'profile_id'      => ['required', 'integer'],
            'gender'          => ['required', 'string', 'max:20'],
            'subred'          => ['required', 'string', 'max:100'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'document_number' => $data['document_number'],
            'document_type'   => $data['document_type'],
            'profile_id'      => $data['profile_id'],
            'gender'          => $data['gender'],
            'subred'          => $data['subred'],
            'password'        => Hash::make($data['password']),
        ]);

        Activity::create([
            'type' => 'usuario',
            'title' => 'Nuevo usuario registrado',
            'description' => $data['name'] . ' se unió al curso de Bienestar Familiar',
        ]);

        return $user;
    }
}
