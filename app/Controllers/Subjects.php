<?php

namespace App\Controllers;

class Subjects extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield               = 'subID';
        $this->data['module_title'] = 'subjects';
        $this->data['module_desc']  = 'Description';
        $this->data['current_page'] = $this->current_page = site_url('subjects');
        $this->module_path          = 'modules/subjects/';
        $this->builder              = $this->table('subjects');
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
        $builder2 = $this->table('faculty');
        $builder2->select('*');
        $this->data['faculty']  = $builder2->get()->getResult();

        echo view('header', $this->data);
        echo view($this->module_path   . '/create');
        echo view('footer');
    }

    public function save()
    {
        $subCode = $this->request->getPost('subCode');
        $title   = $this->request->getPost('title');

        $data = [
            'subCode' => $subCode,
            'title'   => $title,
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

        $builder2 = $this->table('faculty');
        $builder2->select('*');
        $this->data['faculty']  = $builder2->get()->getResult();

        echo view('header', $this->data);
        echo view($this->module_path   . '/edit');
        echo view('footer');
    }

    public function update()
    {
        $id      = $this->request->getPost('id');
        $subCode = $this->request->getPost('subCode');
        $title   = $this->request->getPost('title');
        $status  = $this->request->getPost('status');

        $data = [
            'subCode' => $subCode,
            'title'   => $title,
            'status'  => $status,
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
