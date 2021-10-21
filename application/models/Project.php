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

	public function in(array $data) {
		$this->db->where_in('id', $data);
		return $this->db->get($this->table);
	}
}

/* End of file Project.php */
/* Location : ./application/models/Project.php */