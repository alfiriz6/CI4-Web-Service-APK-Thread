<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;


class Register extends ResourceController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $message = [];
        if (!$this->validate([
            'username' => [
                'rules' => 'required|max_length[30]|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username harus diisi!',
                    'max_length' => 'Username maksimal 30 Karakter',
                    'is_unique' => 'Username telah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'Password harus diisi!',
                    'max_length' => 'Password maksimal 50 Karakter'
                ]
            ],
            'kpassword' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sesuai dengan Password'
                ]
            ],
            'nama' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama harus diisi!',
                    'max_length' => 'Nama maksimal 100 Karakter'
                ]
            ],
            'email' => [
                'rules' => 'required|max_length[50]|is_unique[user.email]|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi!',
                    'max_length' => 'Email maksimal 50 Karakter',
                    'is_unique' => 'Email telah terdaftar',
                    'valid_email' => 'Email harus valid!'
                ]
            ],
        ])) {
            $i = 0;
            foreach ($this->validator->getErrors() as $key => $value) {
                $message[$i] = $value;
                $i++;
            }
            $hasil = [
                'status' => 400,
                'error' => $message
            ];
            return $this->respond($hasil);
        }
        $this->userModel->insert([
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email')
        ]);
        $hasil = [
            'status' => 200,
            'error' => $message,
        ];
        return $this->respond($hasil);
    }
}
