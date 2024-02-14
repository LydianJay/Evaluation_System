<?php

namespace App\Controllers;

class Faculty extends BaseController
{
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'faculty';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = site_url('faculty');
        $this->module_path             = 'modules/faculty/';
        $this->builder                 = $this->table('faculty');
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
        $data = $this->data;

        $builder = $this->db->table('subjects');
        $builder->select('*');
        $subjects = $builder->get()->getResult();

        $data['subjects'] = $subjects;

        echo view('header',   $data);
        echo view($this->module_path   . '/create');
        echo view('footer');
    }

    public function save()
    {
        $idno      = $this->request->getPost('idno');
        $fname     = $this->request->getPost('fname');
        $mname     = $this->request->getPost('mname');
        $lname     = $this->request->getPost('lname');
        $position  = $this->request->getPost('position');

        $data = [
            'idno'       => $idno,
            'fname'      => $fname,
            'lname'      => $lname,
            'mname'      => $mname,
            'lname'      => $lname,
            'position'   => $position
        ];

        if ($this->builder->insert($data)) {
            $id = $this->db->insertID();

            $this->setMessage('success', 'Account successfully created');
            return redirect()->to('faculty/view/' . $id);
        } else {
            $this->setMessage('danger', 'Error creating account');
            return redirect()->to('faculty');
        }
    }

    public function view($id)
    {
        $this->builder->select('*');
        $this->builder->where($this->pfield, $id);
        $this->data['records'] = $this->builder->get()->getFirstRow();

        $builder2 = $this->db->table('ballot');
        $builder2->select('SUM(ballot.rating) as total_rating');
        $builder2->select('subjects.title');
        $builder2->select('subjects.subCode');
        $builder2->select('evaluations.name');
        $builder2->select('evaluations.id');
        $builder2->join('subjects', 'subjects.subID = ballot.subID', 'left');
        $builder2->join('evaluations', 'evaluations.id = ballot.evaluationID', 'left');
        $builder2->where('facultyID', $id);
        $builder2->groupBy('evaluationID');
        $result = $builder2->get()->getResult();


        $this->data['result'] = $result;

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
        $idno      = $this->request->getPost('idno');
        $fname     = $this->request->getPost('fname');
        $mname     = $this->request->getPost('mname');
        $lname     = $this->request->getPost('lname');
        $position  = $this->request->getPost('position');

        $data = [
            'idno'       => $idno,
            'fname'      => $fname,
            'lname'      => $lname,
            'mname'      => $mname,
            'lname'      => $lname,
            'position'   => $position
        ];

        $this->builder->set($data);
        $this->builder->where($this->pfield, $id);
        if ($this->builder->update()) {
            $this->setMessage('success', 'Account successfully updated');
            return redirect()->to('faculty/view/' . $id);
        } else {
            $this->setMessage('danger', 'Error updating account');
            return redirect()->to('faculty/view/' . $id);
        }
    }
}
