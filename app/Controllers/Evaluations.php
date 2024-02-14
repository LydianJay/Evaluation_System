<?php

namespace App\Controllers;

class Evaluations extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'evaluations';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('evaluations');
        $this->module_path             = 'modules/evaluations/';
        $this->builder                 = $this->table('evaluations');
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
        $name            = $this->request->getPost('name');
        $desc            = $this->request->getPost('desc');
        $dateCreated     = date('Y-m-d H:i:s');

        $data = [
            'name'          => $name,
            'desc'          => $desc,
            'dateCreated'   =>  $dateCreated,
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
        $data = $this->data;

        $this->builder->select('*');
        $this->builder->where($this->pfield, $id);
        $eval = $records = $this->builder->get()->getRow();
        
        $builder1 = $this->db->table('ballot');
        $builder1->select('*');
        $data['count'] = $builder1->countAllResults();

        $data['result'] = array();
        if ($records->status == 0) {
    
            $builder1->select('ballot.id');
            $builder1->select('ballot.evaluationID');
            $builder1->select('ballot.facultyID');
            $builder1->select('ballot.studentID');
            $builder1->select('ballot.questionID');
            $builder1->select('ballot.subID');
            $builder1->select('SUM(ballot.rating) as total_rating');
            $builder1->select('faculty.*');
            $builder1->select('subjects.*');
            $builder1->join('faculty', 'faculty.id = ballot.facultyID', 'left');
            $builder1->join('subjects', 'subjects.subID = ballot.subID', 'left');
            $builder1->where('ballot.evaluationID', $id);
            $builder1->groupBy('ballot.subID');
            $builder1->orderBy('total_rating', 'desc');
            $results = $builder1->get()->getResult();

            $builder3 = $this->table('ballot');
            $data['noStud'] = $builder3->countAllResults();

            $builder3 = $this->table('questions');
            $data['noQues'] = $builder3->countAllResults();
            $data['result'] = $results;
        }

        $data['records'] = $eval;
 
        echo view('header', $data);
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
        $id          = $this->request->getPost('id');
        $name        = $this->request->getPost('name');
        $desc        = $this->request->getPost('desc');
        $status      = $this->request->getPost('status');
        $dateCreated = date('Y-m-d H:i:s');

        $data = [
            'name'          => $name,
            'desc'          => $desc,
            'dateCreated'   => $dateCreated,
            'status'        => $status,
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

    public function result()
    {
        $facultyQuery = $this->db->table('faculty')
            ->select('faculty.id, faculty.fname, faculty.mname, faculty.lname, SUM(ballot.rating) AS total_rating')
            ->join('ballot', 'faculty.id = ballot.facultyID', 'left')
            ->groupby('faculty.id, faculty.fname')
            ->orderBy('total_rating', 'desc') // Order by total_rating in descending order
            ->get();
        $facultyResults = $facultyQuery->getResult();

        $this->data['result'] = $facultyResults;

        echo view($this->module_path . '/header', $this->data);
        echo view($this->module_path . '/result');
        echo view($this->module_path . '/header');
    }
}
