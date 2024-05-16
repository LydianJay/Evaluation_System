<?php

namespace App\Controllers;

class Summary extends BaseController
{
    private $current_page;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'id';
        $this->data['module_title']    = 'summary';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page =  site_url('summary');
        $this->module_path             = 'modules/summary/';
        $this->builder                 = $this->table('evaluations');
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $data = $this->data;

        $data['selectedYear']       = $this->request->getPost('acadYearField');
        $data['selectedTerm']       = $this->request->getPost('termField');
        if(isset($data['selectedYear']) && isset($data['selectedTerm']) ){
            $textTerm           = ($data['selectedTerm'] == 1) ? '1st Sem' : '2nd Sem';
            $data['textTerm']   = $textTerm.' '.$data['selectedYear'].'-'.$data['selectedYear']+1;
        }


        $condition_fields = array(
            array(
                'variable'      => 'facultyID',
                'field'         => 'facultyID',
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
        $recFaculty     = array();
        $noStud         = 0;
        if ($facultyID) {
            $getFaculty  = $this->db->table('faculty');
            $getFaculty->where('id', $facultyID);
            $recFaculty = $getFaculty->get()->getRow();

            $builder = $this->db->table('ballot');
            $builder->select(' SUM(ballot.rating) as total_rating, catID, COUNT(studentID)/5 as studCount');
            $builder->select('subjects.subCode, subjects.title');
            $builder->join('subjects', 'subjects.subID = ballot.subID', 'left');
            $builder->join('evaluations', 'evaluations.id = ballot.evaluationID', 'left');
            $builder->where('facultyID', $facultyID);
            $builder->where('evaluations.acadYear', $data['selectedYear']);
            $builder->where('evaluations.term', $data['selectedTerm']);
            $builder->groupBy('title'); // Group by title
            $builder->groupBy('catID'); // Group by catID
            $builder->orderBy('facultyID', 'asc'); // Order by catID in ascending order
            $recordings = $builder->get()->getResult();

            $builder->select('studentID, facultyID');
            $builder->where('facultyID', $facultyID);
            $builder->groupBy('studentID');         // Group by title
            $builder->groupBy('subID');         // Group by title
            $noStud  = $builder->countAllResults();


            // Check if records are found
            if ($recordings) {
                foreach ($recordings as $recording) {
                    // Check if the title key already exists in the groupedRecords array
                    if (!isset($groupedRecords[$recording->title])) {
                        // If the title key doesn't exist, create an array for it
                        $groupedRecords[$recording->title] = array(
                            'title' => $recording->title,
                            'cat' . $recording->catID => $recording->total_rating,
                            'count' => $recording->studCount,
                        );
                    } else {
                        // If the title key already exists, add the category information to it
                        $groupedRecords[$recording->title]['cat' . $recording->catID] = $recording->total_rating;
                    }
                }
            } else {
                // If no records found, you might want to initialize $groupedRecords with some default values.
                $groupedRecords = array(
                    'DefaultTitle' => array(
                        'title' => '',
                        'cat1'  => 0,
                        'cat2'  => 0,
                        'cat3'  => 0,
                        'cat4'  => 0,
                        'count' => 0,
                        // Add more default values as needed.
                    ),
                );
            }
            // Now $groupedRecords contains the grouped data with titles as keys, and categories as associative arrays.
            // You can use this array as needed in your application.
        }

        $data['countStud']          = $noStud;

        // Pass the grouped records to the view
        $data['groupedRecords']     = $groupedRecords;

        $evaluations          = $this->db->table('faculty');
        $evaluations->orderBy('fname', 'asc');
        $data['evaluations'] = $evaluations->get()->getResult();

        $categories          = $this->db->table('categories');
        $data['categories']  = $categories->get()->getResult();

        $data['facultyID']  = $facultyID;
        $data['recFaculty'] = $recFaculty;
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
}
