<?php

namespace App\Controllers;

class Mobile extends BaseController
{
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield               = 'id';
        $this->data['module_title'] = 'Evaluation';
        $this->data['module_desc']  = 'Description';
        $this->data['current_page'] = site_url('mobile');
        $this->module_path          = 'modules/mobile/';
        $this->builder              = $this->table('evaluations');
    }

    public function index()
    {
        return view($this->module_path  . 'login', $this->data);
    }

    public function saveLogin()
    {
        $username = $this->request->getPost('username');

        $this->builder = $this->table('students');
        $this->builder->select('id, idno, fname, mname, lname, course, yr_lvl, status, courseID');
        $this->builder->where('idno', $username);
        $record = $this->builder->get()->getRow();

        if (!empty($record)) {
            $data['studentLogin'] = [
                'id'       => $record->id,
                'idno'     => $record->idno,
                'fname'    => $record->fname,
                'mname'    => $record->mname,
                'lname'    => $record->lname,
                'courseID' => $record->courseID,
                'yr_lvl'   => $record->yr_lvl,
                'status'   => $record->status,
            ];

            $this->session->set($data);
            return redirect()->to(site_url('mobile/show'));
        } else {
            $this->setMessage('danger', 'User not found');
            return redirect()->to(site_url('mobile'));
        }
    }

    public function list($evaluationID)
    {
        $data = $this->data;

        $data['studentIdno'] = $this->session->studentLogin['idno'];
        $data['studentID']   = $this->session->studentLogin['id'];

        $builder2 = $this->table('blocksections_details');
        $builder2->select('blocksections_details.*');
        $builder2->select('faculty.*');
        $builder2->select('subjects.*');
        $builder2->join('faculty', 'blocksections_details.facultyID = faculty.id', 'left');
        $builder2->join('subjects', 'blocksections_details.subID = subjects.subID', 'left');
        $builder2->where('studentID', $this->session->studentLogin['id']);
        $builder2->where('evaluationID', $evaluationID);
        $data['records'] = $builder2->get()->getResult();

        $builder3 = $this->table('evaluations');
        $builder3->select('status');
        $builder3->where('id', $evaluationID);
        $data['evalstat'] = $builder3->get()->getRow();

        $data['evaluationID'] = $evaluationID;

        $data['module_title'] = "Faculty";

        echo view($this->module_path . '/header', $data);
        echo view($this->module_path . '/list');
        echo view($this->module_path . '/header');
    }

    public function result()
    {
        $facultyQuery = $this->db->table('faculty')
            ->select('faculty.id, faculty.fname, faculty.mname, faculty.lname, SUM(ballot.rating) AS total_rating')
            ->join('ballot', 'faculty.id = ballot.facultyID', 'left')
            ->groupby('faculty.id, faculty.fname')
            ->orderBy('total_rating', 'desc')  // Order by total_rating in descending order
            ->get();
        $facultyResults = $facultyQuery->getResult();

        $this->data['result'] = $facultyResults;

        echo view($this->module_path . '/header', $this->data);
        echo view($this->module_path . '/result');
        echo view($this->module_path . '/header');
    }

    public function evaluate($evaluationID, $facultyID, $subID)
    {
        $data = $this->data;

        $this->builder = $this->table('blocksections_details');
        $this->builder->select('blocksections_details.*');
        $this->builder->select('faculty.*');
        $this->builder->select('subjects.*');
        $this->builder->join('faculty', 'blocksections_details.facultyID = faculty.id', 'left');
        $this->builder->join('subjects', 'blocksections_details.subID = subjects.subID', 'left');
        $this->builder->where('blocksections_details.facultyID', $facultyID);
        $this->builder->where('blocksections_details.subID', $subID);
        $this->builder->where('blocksections_details.studentID', $this->session->studentLogin['id']);
        $data['records'] = $this->builder->get()->getFirstRow();

        $this->builder = $this->db->table('categories');
        $this->builder->select('categories.*');
        $this->builder->orderBy('catName', 'asc');
        $categories = $this->builder->get()->getResult();

        $questions = array();
        foreach ($categories as $cat) {
            $builder2 = $this->db->table('questions_details');
            $builder2->where('catID', $cat->catID);
            $builder2->orderBy('quesNo', 'asc');
            $temp = $builder2->get()->getResult();

            $questions[$cat->catID]['category'] = $cat;

            if ($temp) {
                $questions[$cat->catID]['questions'] = $temp;
            } else {
                $questions[$cat->catID]['questions'] = array();  // Ensure an empty array if no questions found
            }
        }

        $data['questions']    = $questions;
        $data['subID']        = $subID;
        $data['facultyID']    = $facultyID;
        $data['studentIdno']  = $this->session->studentLogin['idno'];
        $data['evaluationID'] = $evaluationID;
        $data['studentID']    = $this->session->studentLogin['id'];
        $data['courseID']     = $this->session->studentLogin['courseID'];

        $data['module_title'] = "Evaluate";



        echo view($this->module_path . '/header', $data);
        echo view($this->module_path . '/evaluate');
        echo view($this->module_path . '/header');
    }

    public function show()
    {
        $this->builder = $this->table('evaluations');
        $this->builder->select('*');
        $this->builder->orderBy('evalOrder', 'asc');
        $this->data['records'] = $this->builder->get()->getResult();

        echo view($this->module_path . '/header', $this->data);
        echo view($this->module_path . '/show');
        echo view($this->module_path . '/header');
    }

    public function create()
    {
        echo view('header', $this->data);
        echo view($this->module_path   . '/create');
        echo view('footer');
    }

    public function myscore($evaluationID, $facultyID, $subID)
    {
        $data = $this->data;

        $data['facultyID']    = $facultyID;
        $data['studentIdno']  = $this->session->studentLogin['idno'];
        $data['evaluationID'] = $evaluationID;
        $data['studentID']    = $this->session->studentLogin['id'];
        $data['subID']        = $subID;

        $this->builder = $this->table('blocksections_details');
        $this->builder->select('blocksections_details.*');
        $this->builder->select('faculty.*');
        $this->builder->select('subjects.*');
        $this->builder->join('faculty', 'blocksections_details.facultyID = faculty.id', 'left');
        $this->builder->join('subjects', 'blocksections_details.subID = subjects.subID', 'left');
        $this->builder->where('blocksections_details.facultyID', $facultyID);
        $this->builder->where('blocksections_details.subID', $subID);
        $this->builder->where('blocksections_details.studentID', $this->session->studentLogin['id']);
        $data['records'] = $this->builder->get()->getFirstRow();
        

        $this->builder = $this->db->table('categories');
        $this->builder->select('categories.*');
        $this->builder->orderBy('catName', 'asc');
        $categories = $this->builder->get()->getResult();

        $builder3 = $this->table('students');
        $builder3->select('*');
        $builder3->where('id', $data['studentID']);
        $idno = $builder3->get()->getRow()->idno;

        $questions = array();

        foreach ($categories as $cat) {
            $builder2 = $this->db->table('questions_details');
            $builder2->select('questions_details.quesID, questions_details.quesNo, questions_details.title, questions_details.definition');
            $builder2->select('ballot.*');
            $builder2->join('ballot', 'ballot.questionID = questions_details.quesID', 'left');
            $builder2->where('ballot.evaluationID', $evaluationID);
            $builder2->where('ballot.subID', $subID);
            $builder2->where('ballot.catID', $cat->catID);
            $builder2->where('ballot.studentID',  $idno);
            $builder2->where('ballot.facultyID', $facultyID);
            $builder2->orderBy('questions_details.quesNo', 'asc');
            $temp = $builder2->get()->getResult();

            $questions[$cat->catID]['category'] = $cat;

            if ($temp) {
                $questions[$cat->catID]['questions'] = $temp;
            } else {
                $questions[$cat->catID]['questions'] = array();  // Ensure an empty array if no questions found
            }
        }

        $data['questions']    = $questions;
        $data['module_title'] = "My Score";
        $data['isDisabled'] = true;


        $data['session_data'] = $this->session->get('studentLogin');
        $builder4 = $this->db->table('subjects');
        $builder4->select('subjects.title AS sTitle, subjects.subID as sID, subjects.subCode as code');
        $builder4->where('subjects.subID ', $subID);
        $data['sub'] = $builder4->get()->getFirstRow();
       

        echo view($this->module_path . '/header', $data);
        echo view($this->module_path . '/myscore');
        echo view($this->module_path . '/header');
    }

    public function save()
    {
        $this->builder = $this->table('ballot');
        $evaluationID  = $this->request->getPost('evaluationID');
        $facultyID     = $this->request->getPost('facultyID');
        $studentIdno   = $this->request->getPost('studentIdno');
        $studentID     = $this->request->getPost('studentID');
        $subID         = $this->request->getPost('subID');
        $courseID      = $this->request->getPost('courseID');

        $questions = $this->db->table('questions_details');
        $questions->orderBy('quesNo', 'asc');
        $result = $questions->get()->getResult();

        $dataAll = array();
        foreach ($result as $res) {
            $catID      = $this->request->getPost('catID_' . $res->catID);
            $questionID = $this->request->getPost('quesID_' . $res->quesID);
            $rating     = $this->request->getPost('rating_' . $res->quesID);

            // Check if the data already exists
            $existingData = $this->builder
                ->where('evaluationID', $evaluationID)
                ->where('facultyID', $facultyID)
                ->where('studentID', $studentIdno)
                ->where('questionID', $questionID)
                ->where('subID', $subID)
                ->where('courseID', $courseID)
                ->where('catID', $catID)
                ->where('rating', $rating)
                ->countAllResults();

            if (!$existingData) {
                // Data doesn't exist, so insert it
                $data = [
                    'evaluationID' => $evaluationID,
                    'facultyID'    => $facultyID,
                    'studentID'    => $studentIdno,
                    'questionID'   => $questionID,
                    'subID'        => $subID,
                    'courseID'     => $courseID,
                    'catID'        => $catID,
                    'rating'       => $rating
                ];

                if (!$this->builder->insert($data)) {
                    $this->setMessage('danger', 'Error creating account');
                    return redirect()->to('faculty');
                }

                $dataAll[] = $data;
            }
        }


        $builder2 = $this->table('blocksections_details');
        $builder2->set('bstatus', 1);
        $builder2->where('facultyID', $facultyID);
        $builder2->where('studentID', $studentID);
        $builder2->where('subID',  $subID);
        $builder2->update();

        $this->setMessage('success', 'Succesfully evaluated');
        return redirect()->to('mobile/list/' . $evaluationID);
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
        $id       = $this->request->getPost('id');
        $idno     = $this->request->getPost('idno');
        $fname    = $this->request->getPost('fname');
        $mname    = $this->request->getPost('mname');
        $lname    = $this->request->getPost('lname');
        $position = $this->request->getPost('position');

        $data = [
            'idno'     => $idno,
            'fname'    => $fname,
            'lname'    => $lname,
            'mname'    => $mname,
            'lname'    => $lname,
            'position' => $position
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

    public function logout()
    {
        $this->session->remove('studentLogin');

        return redirect()->to('mobile');
    }
}
