<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template', ['module' => 'admin']);
		$this->load->model('admin');
		if (empty($this->session->userdata('admin')))
		{
			if (!in_array($this->router->fetch_method(), ['login', 'register', 'forgot_password']))
			{
				redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
			}
		}
	}

	public function index()
	{
		$this->template->load('home');
	}

	public function login()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('identity', 'Email/Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$admin = $this->admin->masuk($this->input->post('identity'), $this->input->post('password'));
				if ($admin->num_rows() >= 1)
				{
					$this->session->set_userdata(strtolower($this->router->fetch_class()), $admin->row()->id);
					redirect(base_url($this->router->fetch_class()), 'refresh');
				}
				else
				{
					redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
				}
			}
			else
			{
				$this->load->view('admin/login');
			}
		}
		else
		{
			$this->load->view('admin/login');
		}
	}

	public function profile($id = NULL)
	{
		$data['profile'] = $this->admin->detail(array('id' => (!empty($id))?$id:$this->session->userdata(strtolower($this->router->fetch_class()))));
		$this->load->view('admin/profile');
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
	}

	public function register()
	{
		$this->load->view('admin/register');
	}

	public function forgot_password()
	{
		if ($this->input->method() == 'post')
		{

		}
		else
		{
			$this->load->view('admin/forgot_password');
		}
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
			redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
		}
		else
		{
			redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
		}		
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */