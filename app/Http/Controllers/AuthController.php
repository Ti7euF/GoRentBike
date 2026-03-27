<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{
    protected $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }

    public function login() {
        if(session()->has('userId')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function register() {
        if(session()->has('userId')) {
            return redirect()->route('home');   
        }

        return view('auth.register');
    }

    private function openSession(User $user) {
        session([ 
            'userId' => $user->getIdUser(), 
            'role' => $user->getIdRole(), 
            'name' => $user->getFirstName() 
        ]);
    }

    private function closeSession() {
        session()->flush();
    }

    public function authenticate(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->repo->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return redirect()->back()->with('error', 'Datos erróneos.');
        }

        $this->openSession($user);

        return redirect()->route('home');
    }

    public function createUserAccount(Request $request) {
        if (!$this->isValidUserData($request)) {
            return redirect()->back()->with('error', 'Datos inválidos.');     
        }  
    
        $email = $request->input('email');

        $userExist = $this->repo->findByEmail($email);

        if ($userExist) {
            return redirect()->back()->with('error', 'Ya existe una cuenta registrada con este email.');       
        }

        $user = new User([
            'idRole' => 4,
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
            'active' => 1
        ]);

        $created = $this->repo->create($user);

        if (!$created) {  
            return redirect()->back()->with('error', 'No se pudo crear la cuenta. Intenta de nuevo más tarde.');    
        }

        $this->openSession($user);

        return redirect()->route('home');
    }

    public function logout() {
        $this->closeSession();
        return redirect()->route('home');
    }

    private function isValidUserData(Request $request) {
        $firstName = trim($request->input('firstName'));
        $lastName = trim($request->input('lastName'));
        $email = trim($request->input('email'));
        $password = $request->input('password');

        if (empty($firstName) || strlen($firstName) > 50 || empty($lastName) || strlen($lastName) > 50 || empty($email) || strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
            return false;
        }

        return true;
    }
}