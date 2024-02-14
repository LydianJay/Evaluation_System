<?php

namespace App\Controllers;

class Students extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'students';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('students');
        $this->module_path             = 'modules/students/';
        $this->builder                 = $this->table('students');
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->builder->select('students.*');
        $this->builder->select('courses.*');
        $this->builder->join('courses', 'courses.courseID = students.courseID', 'left');
        $this->data['records'] = $records = $this->builder->get()->getResult();

        echo view('header', $this->data);
        echo view($this->module_path   . '/list');
        echo view('footer');
    }

    public function create()
    {
        $data = $this->data;

        $builder = $this->db->table('courses');
        $builder->select('*');
        $data['courses'] = $builder->get()->getResult();

        echo view('header', $data);
        echo view($this->module_path   . '/create');
        echo view('footer');
    }

    public function save()
    {
        $idno     = $this->request->getPost('idno');
        $fname    = $this->request->getPost('fname');
        $mname    = $this->request->getPost('mname');
        $lname    = $this->request->getPost('lname');
        $courseID = $this->request->getPost('courseID');
        $yr_lvl   = $this->request->getPost('yr_lvl');

        $data = [
            'idno'     => $idno,
            'fname'    => $fname,
            'lname'    => $lname,
            'mname'    => $mname,
            'lname'    => $lname,
            'yr_lvl'   => $yr_lvl,
            'courseID' => $courseID,
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
        $this->builder->select('students.*');
        $this->builder->select('courses.*');
        $this->builder->join('courses', 'courses.courseID = students.courseID', 'left');
        $this->builder->where('students.' . $this->pfield, $id);
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
        $builder2->select('evaluations.*');
        $builder2->join('faculty', 'blocksections_details.facultyID= faculty.id', 'left');
        $builder2->join('subjects', 'blocksections_details.subID= subjects.subID', 'left');
        $builder2->join('evaluations', 'blocksections_details.evaluationID= evaluations.id', 'left');
        $builder2->where('studentID', $records->id);
        $builder2->orderBy('faculty.fname', 'asc');
        $builder2->orderBy('evaluations.name', 'asc');
        $this->data['blocksections_details'] = $builder2->get()->getResult();

        $builder3 = $this->table('evaluations');
        $builder3->select('*');
        $builder3->orderBy('name', 'asc');
        $this->data['evaluations'] = $builder3->get()->getResult();

        echo view('header', $this->data);
        echo view($this->module_path   . '/view');
        echo view('footer');
    }

    public function enroll()
    {
        $studentID    = $this->request->getPost('studentID');
        $facultyID    = $this->request->getPost('facultyID');
        $subID        = $this->request->getPost('subID');
        $evaluationID = $this->request->getPost('evaluationID');

        $data = [
            'studentID'    => $studentID,
            'facultyID'    => $facultyID,
            'subID'        => $subID,
            'evaluationID' => $evaluationID,
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
        $data = $this->data;

        $this->builder->select('*');
        $this->builder->where($this->pfield, $id);
        $data['records'] = $this->builder->get()->getFirstRow();


        $builder = $this->db->table('courses');
        $builder->select('*');
        $data['courses'] = $builder->get()->getResult();

        echo view('header', $data);
        echo view($this->module_path   . '/edit');
        echo view('footer');
    }

    public function update()
    {
        $id        = $this->request->getPost('id');
        $idno     = $this->request->getPost('idno');
        $fname    = $this->request->getPost('fname');
        $mname    = $this->request->getPost('mname');
        $lname    = $this->request->getPost('lname');
        $courseID = $this->request->getPost('courseID');
        $yr_lvl   = $this->request->getPost('yr_lvl');

        $data = [
            'idno'     => $idno,
            'fname'    => $fname,
            'lname'    => $lname,
            'mname'    => $mname,
            'lname'    => $lname,
            'yr_lvl'   => $yr_lvl,
            'courseID' => $courseID,
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

    public function deactivate($detailsID, $studentID)
    {
        $builder2 = $this->table('blocksections_details');
        $builder2->set('dstatus', 0);
        $builder2->where('detailsID', $detailsID);
        if ($builder2->update()) {
            $this->setMessage('danger', 'Data successfully delated');
            return redirect()->to($this->current_page . '/view/' . $studentID);
        } else {
            $this->setMessage('danger', 'Error enrolling');
            return redirect()->to($this->current_page);
        }
    }

    public function activate($detailsID, $studentID)
    {
        $builder2 = $this->table('blocksections_details');
        $builder2->set('dstatus', 1);
        $builder2->where('detailsID', $detailsID);
        if ($builder2->update()) {
            $this->setMessage('danger', 'Data successfully delated');
            return redirect()->to($this->current_page . '/view/' . $studentID);
        } else {
            $this->setMessage('danger', 'Error enrolling');
            return redirect()->to($this->current_page);
        }
    }
}
