<?php

namespace App\Controllers;

class Courses extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield               = 'courseID';
        $this->data['module_title'] = 'courses';
        $this->data['module_desc']  = 'Description';
        $this->data['current_page'] = $this->current_page = site_url('courses');
        $this->module_path          = 'modules/courses/';
        $this->builder              = $this->table('courses');
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
        $title       = $this->request->getPost('title');
        $description = $this->request->getPost('description');

        $data = [
            'title'       => $title,
            'description' => $description,
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
        $id      = $this->request->getPost('id');
        $title   = $this->request->getPost('title');
        $description  = $this->request->getPost('description');

        $data = [
            'title'   => $title,
            'description'  => $description,
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
