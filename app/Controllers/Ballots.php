<?php

namespace App\Controllers;

class Ballots extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'ballots';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('ballots');
        $this->module_path             = 'modules/ballots/';
        $this->builder                 = $this->table('ballots');
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->data['studentIdno'] = $this->session->studentLogin['idno'];
        $this->data['studentID']   = $this->session->studentLogin['id'];

        $builder2 = $this->table('blocksections_details');
        $builder2->select('blocksections_details.*');
        $builder2->select('faculty.*');
        $builder2->select('subjects.*');
        $builder2->join('faculty', 'blocksections_details.facultyID = faculty.id', 'left');
        $builder2->join('subjects', 'blocksections_details.subID = subjects.subID', 'left');
        $this->data['records'] =  $builder2->get()->getResult();

        $this->data['module_title'] = "Faculty";
        
        echo view('header', $this->data);
        echo view($this->module_path . '/list');
        echo view('footer');
    }

    public function myscore($evaluationID, $facultyID)
    {
        $this->data['facultyID']    = $facultyID;
        $this->data['studentIdno']  = $this->session->studentLogin['idno'];
        $this->data['evaluationID'] = $evaluationID;
        $this->data['studentID']    = $this->session->studentLogin['id'];

        $this->builder = $this->table('faculty');
        $this->builder->select('*');
        $this->builder->where($this->pfield, $facultyID);
        $this->data['records'] = $this->builder->get()->getFirstRow();

        $this->builder = $this->table('ballot');
        $this->builder->select('questions.*');
        $this->builder->select('ballot.*');
        $this->builder->join('questions', 'ballot.questionID = questions.id', 'left');
        $this->builder->where('facultyID', $facultyID);
        $this->builder->where('studentID',  $this->data['studentIdno']);
        $this->data['questions'] = $this->builder->get()->getResult();

        $this->data['module_title'] = "My Score";
        echo view('header', $this->data);
        echo view($this->module_path . '/myscore');
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
        $idno      = $this->request->getPost('idno');
        $fname     = $this->request->getPost('fname');
        $mname     = $this->request->getPost('mname');
        $lname     = $this->request->getPost('lname');
        $course    = $this->request->getPost('course');
        $yr_lvl    = $this->request->getPost('yr_lvl');

        $data = [
            'idno'       => $idno,
            'fname'      => $fname,
            'lname'      => $lname,
            'mname'      => $mname,
            'lname'      => $lname,
            'yr_lvl'     => $yr_lvl,
            'course'     => $course,
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
        $this->data['records'] = $records = $this->builder->get()->getFirstRow();

        $builder2 = $this->table('faculty');
        $builder2->select('*');
        $this->data['faculty'] = $builder2->get()->getResult();

        $builder2 = $this->table('subjects');
        $builder2->select('*');
        $this->data['subjects'] = $builder2->get()->getResult();

        $builder2 = $this->table('blocksections_details');
        $builder2->select('blocksections_details.*');
        $builder2->select('faculty.*');
        $builder2->select('subjects.*');
        $builder2->join('faculty', 'blocksections_details.facultyID= faculty.id', 'left');
        $builder2->join('subjects', 'blocksections_details.subID= subjects.subID', 'left');
        $builder2->where('studentID', $records->id);
        $this->data['blocksections_details'] = $builder2->get()->getResult();

        echo view('header', $this->data);
        echo view($this->module_path   . '/view');
        echo view('footer');
    }

    public function enroll()
    {
        $studentID = $this->request->getPost('studentID');
        $facultyID = $this->request->getPost('facultyID');
        $subID     = $this->request->getPost('subID');

        $data = [
            'studentID' => $studentID,
            'facultyID' => $facultyID,
            'subID'     => $subID,
        ];

        $builder2 = $this->table('blocksections_details');
        if ($builder2->insert($data)) {
            $id = $this->db->insertID();

            $this->setMessage('success', 'Enrolled successfully');
            return redirect()->to($this->current_page . '/view/' . $studentID);
        } else {
            $this->setMessage('danger', 'Error enrolling');
            return redirect()->to($this->current_page);
        }
    }

    public function delete_enroll($detailsID, $studentID)
    {
        $builder2 = $this->table('blocksections_details');
        $builder2->where('detailsID', $detailsID);
        if ($builder2->delete()) {
            $this->setMessage('danger', 'Data successfully delated');
            return redirect()->to($this->current_page . '/view/' . $studentID);
        } else {
            $this->setMessage('danger', 'Error enrolling');
            return redirect()->to($this->current_page);
        }
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
        $course    = $this->request->getPost('course');
        $yr_lvl    = $this->request->getPost('yr_lvl');

        $data = [
            'idno'       => $idno,
            'fname'      => $fname,
            'lname'      => $lname,
            'mname'      => $mname,
            'lname'      => $lname,
            'yr_lvl'     => $yr_lvl,
            'course'     => $course,
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
