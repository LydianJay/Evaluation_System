<?php

namespace App\Controllers;


class SummarySem extends BaseController {

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
        $data['current_page'] = site_url('summarysem');
        $data['module_title'] = 'summarysem';
        
        $fID = $this->request->getPost('fName');

        
        $data['selectedID'] = $this->db->table('faculty')->select('id, fname, lname')->where('id', $fID)->get()->getRow();
        
        



        $facultyTbl = $this->db->table('faculty');
        $facultyTbl->select('id, fname, lname');
        $facultyTbl->orderBy('lname');
        $fRes = $facultyTbl->get()->getResult();
        $data['fnames'] = $fRes;



        $ballotTbl = $this->db->table('ballot');
        $ballotTbl->select('SUM(ballot.rating) AS sum, ballot.evaluationID AS evalID, COUNT(ballot.rating) as no');
        $ballotTbl->join('evaluations', 'ballot.evaluationID = evaluations.id');
        $ballotTbl->where('facultyID', $fID);
        $ballotTbl->orderBy('evaluations.id');
        $res = $ballotTbl->get()->getResult();
        $data['query'] = $res;
        
        $eval = $this->db->table('evaluations');
        $eval->select('name, id');
        $eval->orderBy('evalOrder');
        $resEval = $eval->get()->getResult();
        $data['evalrow'] = $resEval;
       

        echo view('header', $data);
        echo view('modules/summarysem/summaryview');
        echo view('footer', $this->footerData);
    }


}