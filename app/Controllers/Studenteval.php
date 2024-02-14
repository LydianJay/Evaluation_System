<?php

namespace App\Controllers;

class Studenteval extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'studenteval';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('studenteval');
        $this->module_path             = 'modules/studenteval/';
        $this->builder                 = $this->table('students');
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $data  = $this->data;

        $condition_fields = array(
            array(
                'variable'      => 'courseID',
                'field'         => "courseID",
                'default_value' => "",
                'operator'      => 'where'
            ),
            array(
                'variable'      => 'evaluationID',
                'field'         => 'evaluationID',
                'default_value' => "",
                'operator'      => 'where'
            ),
            array(
                'variable'      => 'subjectID',
                'field'         => 'subjectID',
                'default_value' => "",
                'operator'      => 'where'
            ),
        );

        //get the controller
        $controller = service('uri')->getSegment(2);

        // start source of filtering
        $filter_source = 0;  // default/blank
        if ($this->request->getPost('filterflag') || $this->request->getPost('sortby')) {
            $filter_source = 1;
        } else {
            foreach ($condition_fields as $key) {
                if ($this->request->getPost($key['variable'])) {
                    $filter_source = 1;  // form filters
                    break;
                }
            }
        }

        if (!$filter_source) {
            foreach ($condition_fields as $key) {
                if ($this->session->get($controller . '_' . $key['variable']) || $this->session->get($controller . '_sortby') || $this->session->get($controller . '_sortorder')) {
                    $filter_source = 2;  // session
                    break;
                }
            }
        }

        switch ($filter_source) {
            case 1:
                foreach ($condition_fields as $key) {
                    ${$key['variable']} = $this->request->getPost($key['variable']);
                }

                break;
            case 2:
                foreach ($condition_fields as $key) {
                    ${$key['variable']} = $this->session->get($controller . '_' . $key['variable']);
                }

                break;
            default:
                foreach ($condition_fields as $key) {
                    ${$key['variable']} = $key['default_value'];
                }
        }

        // set session variables
        foreach ($condition_fields as $key) {
            $this->session->set($controller . '_' . $key['variable'], ${$key['variable']});
        }
        

        $groupedRecords = array();
        if ($courseID && $evaluationID) {
            $students = $this->db->table('students');
            $students->select('students.*, blocksections_details.*, courses.title as course_title, subjects.title as subject_title');
            
            $students->join('blocksections_details', 'blocksections_details.studentID = students.id', 'left');
            $students->join('courses', 'courses.courseID = students.courseID', 'left');
            $students->join('subjects', 'subjects.subID = blocksections_details.subID', 'left');
            $students->where('students.courseID', $courseID);
            $students->where('subjects.subID', $subjectID);
            $students->groupBy(['students.idno', 'subID']);
            $students->orderBy('students.idno');
            $getStud = $students->get()->getResult();
            // ...

            foreach ($getStud as $stud) {
                // Retrieve ballot information
                $builder = $this->db->table('ballot');
                $builder->select('SUM(rating) as total_rating, id, catID');
                $builder->where('studentID', $stud->idno);
                $builder->where('subID', $stud->subID);
                $builder->where('courseID', $stud->courseID);
                $builder->where('evaluationID', $evaluationID);
                $builder->groupBy(['studentID', 'subID', 'catID']); // Include 'studentID' and 'subID' in grouping
                $builder->orderBy('catID', 'asc');
                $recordings = $builder->get()->getResult();

                // Check if records are found
                if ($recordings) {
                    // Use a unique key for each student and subject combination
                    $groupedRecords[$stud->id . '_' . $stud->subID] = $stud;
                    $groupedRecords[$stud->id . '_' . $stud->subID]->cat1 = 0;
                    $groupedRecords[$stud->id . '_' . $stud->subID]->cat2 = 0;
                    $groupedRecords[$stud->id . '_' . $stud->subID]->cat3 = 0;
                    $groupedRecords[$stud->id . '_' . $stud->subID]->cat4 = 0;

                    // Populate category ratings for each student and subject combination
                    foreach ($recordings as $recording) {
                        $catID = 'cat' . $recording->catID;
                        $groupedRecords[$stud->id . '_' . $stud->subID]->$catID = $recording->total_rating;
                    }
                }
            }
        }

        $data['records'] = $groupedRecords;

        $courses = $this->db->table('courses');
        $courses->orderBy('title', 'asc');
        $data['courses'] = $courses->get()->getResult();

        $evaluations = $this->db->table('evaluations');
        $evaluations->orderBy('name', 'asc');
        $data['evaluations'] = $evaluations->get()->getResult();

        $subjects = $this->db->table('subjects');
        $subjects->orderBy('subCode', 'asc');
        $data['subjects'] = $subjects->get()->getResult();

        $faculty = $this->db->table('faculty');
        $faculty->orderBy('fname', 'asc');
        $faculty->distinct();
        $data['faculty'] = $faculty->get()->getResult();


        $data['getEval']    = $evaluations->where('id', $evaluationID)->get()->getRow();
        $data['getCourse']  = $courses->where('courseID', $courseID)->get()->getRow();
        $data['subID']      = $subjects->where('subID', $subjectID)->get()->getRow();
        
        $data['courseID']     = $courseID;
        $data['evaluationID'] = $evaluationID;
        $data['noOfStud']     = count($groupedRecords);

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
