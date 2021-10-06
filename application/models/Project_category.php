<?php
/**
 * @package Codeigniter
 * @subpackage Project_category
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Project_category extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('project_category');
	}
}

/* End of file Project_category.php */
/* Location : ./application/models/Project_category.php */