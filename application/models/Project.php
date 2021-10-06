<?php
/**
 * @package Codeigniter
 * @subpackage Project
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Project extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('project');
	}
}

/* End of file Project.php */
/* Location : ./application/models/Project.php */