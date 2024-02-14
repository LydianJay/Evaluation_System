<?php

namespace App\Controllers;

class Login extends BaseController
{
    private $current_page;
    private $table;
    private $pfield;
    private $module_path;
    private $builder;

    public function __construct()
    {
        $this->pfield                  = 'userID';
        $this->data['module_title']    = 'Console Login';
        $this->data['module_desc']     = 'Description';
        $this->data['current_page']    = $this->current_page = site_url('login');
        $this->module_path             = 'modules/categories/';
        $this->builder                 = $this->table('users');
    }

    public function index()
    {
        return view('login', $this->data);
    }

    public function save()
    {
        $username   = $this->request->getPost('username');
        $password   = $this->request->getPost('password');

        $this->builder->select('username, password, status, userID, fname, mname, lname');
        $this->builder->where('username', $username);
        $record = $this->builder->get()->getRow();

        if (!empty($record)) {
            if ($record && md5(strval($password)) == $record->password) {
                $data['loggedIn'] = [
                    'userID'    => $record->userID,
                    'fname'     => $record->fname,
                    'lname'     => $record->lname,
                    'username'  => $record->username,
                    'status'    => $record->status,
                ];

                $this->session->set($data);
                return redirect()->to(site_url('faculty'));
            } else {
                $this->setMessage('danger', 'Incorrect password');
                return redirect()->to(site_url('login'));
            }
        } else {
            $this->setMessage('danger', 'User not found');
            return redirect()->to(site_url('login'));
        }
    }
}
