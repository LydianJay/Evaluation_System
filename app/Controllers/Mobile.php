<?php

namespace App\Controllers;

class Mobile extends BaseController
{
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'evaluations';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = site_url('mobile');
        $this->module_path             = 'modules/mobile/';
        $this->builder                 = $this->table('evaluations');
    }

    public function index()
    {
        return view($this->module_path  . 'login', $this->data);
    }

    public function saveLogin()
    {
        $username   = $this->request->getPost('username');
        $password   = $this->request->getPost('password');

        $this->builder = $this->table('students');
        $this->builder->select('id, idno, fname, mname, lname, course, yr_lvl, status');
        $this->builder->where('idno', $username);
        $record = $this->builder->get()->getRow();

        if (!empty($record)) {
            if ($password == $record->idno) {
                $data['studentLogin'] = [
                    'id'     => $record->id,
                    'idno'   => $record->idno,
                    'fname'  => $record->fname,
                    'mname'  => $record->mname,
                    'lname'  => $record->lname,
                    'course' => $record->course,
                    'yr_lvl' => $record->yr_lvl,
                    'status' => $record->status,
                ];

                $this->session->set($data);
                return redirect()->to(site_url('mobile/show'));
            } else {
                $this->setMessage('danger', 'Incorrect password');
                return redirect()->to(site_url('mobile'));
            }
        } else {
            $this->setMessage('danger', 'User not found');
            return redirect()->to(site_url('mobile'));
        }
    }

    public function list($evaluationID)
    {
        $this->data['studentIdno'] = $this->session->studentLogin['idno'];
        $this->data['studentID']   = $this->session->studentLogin['id'];

        $builder2 = $this->table('blocksections_details');
        $builder2->select('blocksections_details.*');
        $builder2->select('faculty.*');
        $builder2->join('faculty', 'blocksections_details.facultyID = faculty.id', 'left');
        $builder2->where('studentID', $this->session->studentLogin['id']);
        $this->data['records'] =  $builder2->get()->getResult();

        $this->data['evaluationID'] = $evaluationID;

        $this->data['module_title'] = "Faculty";
        echo view($this->module_path . '/header', $this->data);
        echo view($this->module_path . '/list');
        echo view($this->module_path . '/header');
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

    public function evaluate($evaluationID, $facultyID)
    {
        $this->builder = $this->table('faculty');
        $this->builder->select('*');
        $this->builder->where($this->pfield, $facultyID);
        $this->data['records'] = $this->builder->get()->getFirstRow();

        $this->builder = $this->table('questions');
        $this->builder->select('*');
        $this->builder->orderBy('questionNo', 'asc');
        $this->data['questions'] = $this->builder->get()->getResult();

        $this->data['facultyID']    = $facultyID;
        $this->data['studentIdno']  = $this->session->studentLogin['idno'];
        $this->data['evaluationID'] = $evaluationID;
        $this->data['studentID']    = $this->session->studentLogin['id'];

        $this->data['module_title'] = "Evaluate";
        echo view($this->module_path . '/header', $this->data);
        echo view($this->module_path . '/evaluate');
        echo view($this->module_path . '/header');
    }

    public function show()
    {
        $this->builder = $this->table('evaluations');
        $this->builder->select('*');
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
        echo view($this->module_path . '/header', $this->data);
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

        $questions = $this->db->table('questions');
        $questions->orderBy('questionNo', 'asc');
        $result  =   $questions->get()->getResult();

        foreach ($result as $res) {
            $questionID = $this->request->getPost('question_' . $res->id);
            $rating    = $this->request->getPost('rating_' . $res->id);

            $data = [
                'evaluationID'  => $evaluationID,
                'facultyID'     => $facultyID,
                'studentID'     => $studentIdno,
                'questionID'    => $questionID,
                'rating'        => $rating
            ];

            if (!$this->builder->insert($data)) {
                $id = $this->db->insertID();

                $this->setMessage('danger', 'Error creating account');
                return redirect()->to('faculty');
            }
        }

        $builder2 = $this->table('blocksections_details');
        $builder2->set('bstatus', 1);
        $builder2->where('facultyID', $facultyID);
        $builder2->where('studentID', $studentID);
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

    public function logout()
    {
        $this->session->remove('studentLogin');

        return redirect()->to('mobile');
    }
}
