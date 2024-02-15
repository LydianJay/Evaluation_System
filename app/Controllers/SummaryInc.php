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
        $data['current_page'] = site_url('summaryinc');
        $data['module_title'] = 'summaryinc';
        
        
       

        echo view('header', $data);
        echo view('modules/summaryinc/summaryincview');
        echo view('footer', $this->footerData);
    }


}