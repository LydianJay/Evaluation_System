<?php

namespace App\Controllers;

class Questions extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'questions';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('questions');
        $this->module_path             = 'modules/questions/';
        $this->builder                 = $this->table('questions');
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->builder->select('*');
        $this->data['records'] = $this->builder->get()->getResult();

        echo view('header', $this->data);
        echo view($this->module_path   . '/list');
        echo view('footer');
    }

    public function create()
    {
        echo view('header', $this->data);
        echo view($this->module_path   . '/create');
        echo view('footer');
    }

    public function save()
    {
        $questionNo      = $this->request->getPost('questionNo');
        $questionLabel     = $this->request->getPost('questionLabel');

        $data = [
            'questionNo'       => $questionNo,
            'questionLabel'    => $questionLabel,
        ];

        if ($this->builder->insert($data)) {
            $id = $this->db->insertID();

            $this->setMessage('success', 'Account successfully created');
            return redirect()->to($this->current_page . '/view/' . $id);
        } else {
            $this->setMessage('danger', 'Error creating account');
            return redirect()->to($this->current_page);
        }
    }

    public function view($id)
    {
        $this->builder->select('*');
        $this->builder->where($this->pfield, $id);
        $this->data['records'] = $this->builder->get()->getFirstRow();

        echo view('header', $this->data);
        echo view($this->module_path   . '/view');
        echo view('footer');
    }

    public function edit($id)
    {
        $this->builder->select('*');
        $this->builder->where($this->pfield, $id);
        $this->data['records'] = $this->builder->get()->getFirstRow();

        echo view('header', $this->data);
        echo view($this->module_path   . '/edit');
        echo view('footer');
    }

    public function update()
    {
        $id        = $this->request->getPost('id');
        $questionNo      = $this->request->getPost('questionNo');
        $questionLabel     = $this->request->getPost('questionLabel');

        $data = [
            'questionNo'       => $questionNo,
            'questionLabel'    => $questionLabel,
        ];

        $this->builder->set($data);
        $this->builder->where($this->pfield, $id);
        if ($this->builder->update()) {
            $this->setMessage('success', 'Account successfully updated');
            return redirect()->to($this->current_page . '/view/' . $id);
        } else {
            $this->setMessage('danger', 'Error updating account');
            return redirect()->to($this->current_page);
        }
    }
}
