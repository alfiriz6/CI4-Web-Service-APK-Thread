<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $model = new UserModel();
        $data = $model->orderBy('id', 'ASC')->findAll();
        if ($data) {
            $hasil = [
                'status' => 200,
                'data' => $data
            ];
            return $this->respond($hasil);
        } else {
            $hasil = [
                'status' => 404,
                'message' => 'User tidak ditemukan',
                'data' => null
            ];
            return $this->respond($hasil);
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new UserModel();
        $data = $model->getWhere(['id' => $id])->getRow();
        if ($data) {
            $hasil = [
                'status' => 200,
                'data' => $data
            ];
            return $this->respond($hasil);
        } else {
            $hasil = [
                'status' => 404,
                'message' => 'User tidak ditemukan',
                'data' => null
            ];
            return $this->respond($hasil);
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = [
            'email' => $this->request->getVar('email'),
            'nama' => $this->request->getVar('nama')
        ];

        $this->userModel->update($id, $data);

        $key = getenv('TOKEN_SECRET');
        $payload = array(
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "uid" => $id,
            "email" => $data['email'],
            "username" => $this->userModel->getWhere(['id' => $id])->getRow('username'),
            "nama" => $data['nama'],
            "role" => $this->userModel->getWhere(['id' => $id])->getRow('role')
        );
        $token = JWT::encode($payload, $key, 'HS256');
        $hasil = [
            'status' => 200,
            'error' => null,
            'token' => $token
        ];
        return $this->respond($hasil);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $data = $this->userModel->find($id);
        if ($data) {
            $this->userModel->delete($id);
            $hasil = [
                'status' => 200,
            ];
            return $this->respond($hasil);
        } else {
            $hasil = [
                'status' => 404,
            ];
            return $this->respond($hasil);
        }
    }
}
