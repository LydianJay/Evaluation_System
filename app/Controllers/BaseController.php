<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $data;
    protected $db;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session              = \Config\Services::session();
        $this->db                   =  \Config\Database::connect();
        $this->data['app_title']    = 'Evaluation';
        $this->data['app_desc']     = 'Evaluation Description';
        $this->data['app_owner']    = 'Menchie P. Alindao & Mechaelah M. Famador';
        $this->data['app_yr']       = date('Y');

        $this->data['student'] = "";
        if (isset($this->session->studentLogin['id'])) {
            $this->data['student'] = $this->session->studentLogin['fname'] . ' ' . $this->session->studentLogin['lname'];
        }
    }

    public function table($tbl)
    {
        $this->db  =  \Config\Database::connect();
        $table     = $this->db->table($tbl);
        return $table;
    }

    public function setMessage($type, $message)
    {
        $this->session = session();
        $this->session->setFlashdata('message', $message);
        $this->session->setFlashdata('message_type', $type);
    }
}
