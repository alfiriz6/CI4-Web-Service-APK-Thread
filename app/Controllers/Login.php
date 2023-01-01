<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

use function PHPUnit\Framework\isNull;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    // public function index()
    // {
    //     return view('login');
    // }
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = $this->userModel->where('username', $this->request->getVar('username'))->first();
        if ($user == null) {
            $hasil = [
                'status' => 401,
                'error' => 'Username tidak ditemukan',
                'message' => null,
                'token' => null
            ];
            return $this->respond($hasil);
            $user = $this->userModel->where('email', $this->request->getVar('username'))->first();
            if ($user == null) {
                $hasil = [
                    'status' => 401,
                    'error' => 'Email tidak ditemukan',
                    'message' => null,
                    'token' => null
                ];
                return $this->respond($hasil);
            }
        }
        $verify = strcmp(md5($this->request->getVar('password')), $user['password']);
        if ($verify != 0) {
            $hasil = [
                'status' => 401,
                'error' => 'Password salah',
                'message' => null,
                'token' => null
            ];
            return $this->respond($hasil);
        }
        // var_dump($user);
        $key = getenv('TOKEN_SECRET');
        $payload = array(
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "uid" => $user['id'],
            "email" => $user['email'],
            "username" => $user['username'],
            "nama" => $user['nama'],
            "role" => $user['role'],
        );
        $token = JWT::encode($payload, $key, 'HS256');
        $hasil = [
            'status' => 200,
            'error' => null,
            'message' => 'Login Berhasil',
            'token' => $token,
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        return $this->respond($hasil);
    }
}
