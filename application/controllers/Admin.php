<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template', ['module' => 'admin']);
	}

	public function index()
	{
		$this->template->load('home');
	}

	public function login()
	{
		$this->load->view('admin/login');
	}

	public function register()
	{
		$this->load->view('admin/register');
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */