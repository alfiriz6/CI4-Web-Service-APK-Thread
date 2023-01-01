<?php

namespace App\Controllers;

use App\Models\ThreadModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class Thread extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct()
    {
        $this->threadModel = new ThreadModel();
    }

    public function index()
    {
        $model = new ThreadModel();
        $data = $model->orderBy('tanggal', 'DESC')->findAll();
        if ($data) {
            $hasil = [
                'status' => 200,
                'data' => $data
            ];
            return $this->respond($hasil);
        } else {
            $hasil = [
                'status' => 404,
                'message' => 'Tidak ada thread',
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
        $model = new ThreadModel();
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
                'message' => 'Thread tidak ditemukan',
                'data' => null
            ];
            return $this->respond($hasil);
        }
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $model = new ThreadModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'gambar' => $this->request->getVar('gambar'),
            'isi' => $this->request->getVar('isi'),
            'tanggal' => Time::now('Asia/Jakarta', 'id_ID'),
        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
        ];
        return $this->respondCreated($response);
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
        helper(['form']);
        $rules = [
            'judul' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required' => 'Judul harus diisi',
                    'min_length' => 'Judul minimal 5 Karakter',
                    'max_length' => 'Judul maksimal 255 Karakter',
                ]
            ],
            'isi' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Field Isi harus diisi',
                    'min_length' => 'Field Isi minimal 5 Karakter',
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        $model = new ThreadModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'gambar' => $this->request->getVar('gambar'),
            'isi' => $this->request->getVar('isi'),
            'tanggal' => Time::now('Asia/Jakarta', 'id_ID'),
        ];
        $model->update($id,$data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Thread berhasil diubah'
            ]
        ];
        return $this->respondUpdated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new ThreadModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Thread berhasil dihapus'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Thread tidak ditemukan');
        }
    }
}
