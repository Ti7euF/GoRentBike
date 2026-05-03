<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repoUser;

    public function __construct(UserRepository $repoUser)
    {
        $this->repoUser = $repoUser;
    }

    public function index(Request $request) {
        if(!session()->has('userId')) {
            return redirect()->route('login');
        }    
        
        $limit = 8;
        $page = (int) $request->input('page', 1);    
        $sort = $request->input('sort', 'asc');
        $filter = $request->input('filter', 'all');
        $offset = ($page - 1) * $limit;

        if (session('role') == 1) {
            $users = $this->repoUser->getAllUsers($offset, $limit, $sort, $filter);
            
            $total = $this->repoUser->countUsers($filter);
            $totalPages = ceil($total / $limit);
            $currentPage = $page;
        } else {
            $user = $this->repoUser->getUserById(session('userId'));
            $users = $user ? [$user] : [];

            $total = 1;
            $totalPages = 1;
            $currentPage = 1;
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.tableUser', compact('users'))->render(),
                'pagination' => view('_partials.pagination', compact('currentPage', 'totalPages'))->render()
            ]);
        }

        return view('user.index', ['page' => $page, 'limit' => $limit, 'users' => $users, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }

    public function userUpdateForm(Request $request) {
        if(!session()->has('userId')) {
            return redirect()->route('login');
        }

        $idUser = (int) $request->query('idUser');
    
        if(session('userId') != $idUser && session('role') != 1) {
            return redirect()->route('user.index')->with('error', 'No tienes permisos para modificar este usuario.');
        }

        $user = $this->repoUser->getUserById($idUser);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado.');
        }

        return view('user.formUser', ['user' => $user]);
    }

    public function userUpdate(Request $request) {
        $idUser = $request->input('idUser');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $request->input('email');
        $newRole = $request->input('role', null);
        $password = $request->input('password');
        $confirmPassword = $request->input('confirmPassword');
    
        if (empty($firstName) || strlen($firstName) > 50 || empty($lastName) || strlen($lastName) > 50 || empty($email) || strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Datos inválidos.');
        }

        if (!empty($password) || !empty($confirmPassword)) {
            if (empty($password) || empty($confirmPassword)) {
                return redirect()->route('user.index')->with('error', 'Debe completar ambos campos de contraseña.');
            }

            if ($password !== $confirmPassword) {
                return redirect()->route('user.index')->with('error', 'Las contraseñas no coinciden.');
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

        } else {
            $password = null;
        }

        $updated = $this->repoUser->updateUser($idUser, $firstName, $lastName, $email, $newRole, $password);

        if (!$updated) {
            return redirect()->route('user.index')->with('error', 'No se pudo actualizar el usuario.');
        }

        return redirect()->route('user.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function userDelete(Request $request) {
        if (session('role') != 1) {
            return redirect()->route('user.index')->with('error', 'No tienes permiso para eliminar usuarios.');
        }
    
        $idUser = $request->input('idUser');
        
        if ($this->repoUser->hasRegisters($idUser)) {
            return redirect()->route('user.index')->with('error', 'No se puede eliminar el usuario porque tiene registros asociados.');
        }

        $deleted = $this->repoUser->delete($idUser);

        if (!$deleted) {
            return redirect()->route('user.index')->with('error', 'No se pudo eliminar el usuario.');
        }

        return redirect()->route('user.index')->with('success', 'Usuario eliminado correctamente');
    }
}