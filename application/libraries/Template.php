<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{
	protected $ci;

	protected $module;

	public function __construct($config)
	{
        $this->ci =& get_instance();
        if (isset($config['module'])) {
        	$this->module = $config['module'];
        }
	}

	public function load($page, $params = array())
	{
		$data['page'] = $this->ci->load->view($this->module.'/'.$page, $params, TRUE);
		$data['user'] = $this->ci->user->read(array('id' => $this->ci->session->userdata($this->module)))->row();
		$data['notification'] = $this->ci->notification->get(array('user_id' => $this->ci->session->userdata($this->module), 'read' => 0));
		$this->ci->load->view($this->module.'/base', array_merge($data, $params), FALSE);
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
