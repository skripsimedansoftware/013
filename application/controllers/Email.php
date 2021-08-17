<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$config['useragent'] = 'MedanSoftware';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.medansoftware.my.id';
		$config['smtp_user'] = 'no-reply@medansoftware.my.id';
		$config['smtp_pass'] = 'gP_N.7n2Q~&l';
		$config['smtp_port'] = 465;
		$config['smtp_timeout'] = 6;
		$config['smtp_keepalive'] = TRUE;
		$config['smtp_crypto'] = 'ssl';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = TRUE;
		$config['priority'] = 3;
		$this->load->library('email', $config);
	}

	public function index()
	{
		$this->reset_password();
	}

	public function reset_password($user_id = NULL)
	{
		$this->email->to('agungmasda29@gmail.com');
		$this->email->from('no-reply@medansoftware.my.id', 'Medan Software');
		$this->email->subject('Ganti Kata Sandi');
		$data['link'] = base_url();
		$data['code'] = 1337;
		$data['full_name'] = 'Agung Dirgantara';
		$this->email->message($this->load->view('email/reset_password', $data, TRUE));
		if (!$this->email->send())
		{
			redirect(base_url(), 'refresh');
		}
		else
		{
			redirect(base_url(), 'refresh');
		}		
	}

}

/* End of file Email.php */
/* Location: ./application/controllers/Email.php */