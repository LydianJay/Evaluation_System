<?php

namespace App\Controllers;

class Studenteval extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct() {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'studenteval';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('studenteval');
        $this->module_path             = 'modules/studenteval/';
        $this->builder                 = $this->table('students');
    }

    public function index() {
        $this->list();
    }

    public function list() {
        $data  = $this->data;
        $controller = service('uri')->getSegment(2);
        
        $data['sFaculty']   = $this->request->getPost('facultyField'); 
        $data['sTerm']      = $this->request->getPost('termField');
        $data['sSubject']   = $this->request->getPost('subjectField');
        $data['sYear']      = $this->request->getPost('yearField');

        // ==============================================
        $data['tblFaculty'] = $this->db->table('faculty')->select('fname, lname, id')->get()->getResult();
        $data['tblEval']    = $this->db->table('evaluations')->select('id, name, acadYear, term')->get()->getResult();
        $data['tblSubject'] = $this->db->table('subjects')->select('subID, title')->get()->getResult();
        $data['tblCat']     = $this->db->table('categories')->select('catName, catID')->get()->getResult();        
        $data['noCat']      = count($data['tblCat']);

        if ( 
            isset($data['sFaculty']) && isset($data['sTerm']) &&
            isset($data['sSubject']) && isset($data['sYear'])
        ) {

            $filtered = $this->db->table('ballot')->select('SUM(ballot.rating) as rating, ballot.catID as catID, ballot.studentID as studentID, COUNT(ballot.studentID) as sCount');
            $filtered->join(    'evaluations',             'ballot.evaluationID = evaluations.id', 'right');
            $filtered->where('ballot.facultyID', $data['sFaculty']);
            $filtered->where('evaluations.term', $data['sTerm']);
            $filtered->where('evaluations.acadYear', $data['sYear']);
            $filtered->where('ballot.subID', $data['sSubject']);
            $filtered->groupBy(['ballot.catID', 'ballot.studentID']);
            $filtered->orderBy('ballot.catID, ballot.studentID');
            $data['ratings'] = $filtered->get()->getResult();
            // RAW SQL: SELECT SUM(ballot.rating), ballot.catID, ballot.studentID FROM ballot WHERE facultyID = 84 AND ballot.subID = 33 GROUP BY ballot.catID, ballot.studentID ORDER BY  ballot.catID
           
        }

            




        echo view('header', $data);
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
