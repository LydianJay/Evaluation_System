<?php

namespace App\Controllers;


class SummaryInc extends BaseController {

    private $builder;
    private $footerData;
   
    public function index() {
        $this->list();
    }

    public function __construct() {

        $this->builder = $this->table('ballot');
        $this->footerData['app_yr']         = 2024;
        $this->footerData['app_owner']      = 'LydianJay';
        $this->footerData['app_title']      = 'Evaluation';
        
    }
    
    public function list() {
        $data['current_page']   = site_url('summaryinc');
        $data['module_title']   = 'summaryinc';
        

        // =============== Get all data from selection fields ================
        $data['selectedCourse']     = $this->request->getPost('courseField');
        $data['selectedTerm']       = $this->request->getPost('termField');
        $data['selectedProf']       = $this->request->getPost('profField');
        $data['selectedYear']       = $this->request->getPost('acadYearField');



        // ============ Get data from database to fill the form selection ===================
        $data['courseTbl']          = $this->db->table('courses')->select('title, description, courseID')->get()->getResult();
        $data['facultyTbl']         = $this->db->table('faculty')->select('fname, lname, id')->get()->getResult();
        $data['termTbl']            = $this->db->table('evaluations')->select('name, acadYear, term, id')->get()->getResult();
        $data['catTbl']             = $this->db->table('categories')->select('catName, title, catID')->get()->getResult();
        

        // ========================= Filter Data ===================================
        // Get all rating filtered by course, faculty, term, and academic year. 
        // =========================================================================
        // Check first if the field is all set
        if ( 
            isset($data['selectedTerm']) && isset($data['selectedYear']) &&
            isset($data['selectedProf']) && isset($data['selectedCourse'])
        ) 
        {
            // filter our query by course, term, and faculty 
            $filtered = $this->db->table('ballot')->select('SUM(ballot.rating) as rating, COUNT(ballot.rating) as num, ballot.catID as catID');
            
            $filtered->join(    'evaluations',             'ballot.evaluationID = evaluations.id', 'right');
            
            $filtered->where(   'evaluations.acadYear',    $data['selectedYear']);
            $filtered->where(   'evaluations.term',        $data['selectedTerm']);
            $filtered->where(   'ballot.facultyID',        $data['selectedProf']);
            $filtered->where(   'ballot.courseID',         $data['selectedCourse']);
            $filtered->groupBy(['ballot.catID']);
            $data['ratings'] = $filtered->get()->getResult();
            
            foreach ($data['facultyTbl'] as $fac) {
                if($fac->id == $data['selectedProf']){
                    $data['facultyData'] = $fac;
                }
            }
            foreach ($data['courseTbl'] as $course) {
                if($course->courseID == $data['selectedCourse']){
                    $data['courseData'] = $course;
                }
            }
            foreach ($data['termTbl'] as $term) {
                if($term->id == $data['selectedTerm']){
                    
                    $data['termData'] = ($term->term == 0 ? '1st Semester' : '2nd Semester').' '.$term->acadYear.'-'.($term->acadYear + 1);
                }
            }
        }
        // ==========================================================================


       

        echo view('header', $data);
        echo view('modules/summaryinc/summaryincview');
        echo view('footer', $this->footerData);
    }


}