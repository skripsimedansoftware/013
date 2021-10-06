<?php
/**
 * @package Codeigniter
 * @subpackage Freelancer_project
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Freelancer_project extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('freelancer_project');
	}
}

/* End of file Freelancer_project.php */
/* Location : ./application/models/Freelancer_project.php */