<?php

namespace App\Controllers;

class Logout extends BaseController
{
    private $current_page;
    private $table;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'userID';
        $this->data['module_title']    = 'Login';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page = site_url('login');
        $this->module_path             = 'modules/categories/';
        $this->builder                 = $this->table('users');
    }

    public function index()
    {
        $this->session->remove('loggedIn');

        return redirect()->to('login');
    }

    public function logout()
    {
        $this->session->remove('loggedIn');

        return redirect()->to('login');
    }
}
