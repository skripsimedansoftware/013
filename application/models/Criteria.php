<?php
/**
 * @package Codeigniter
 * @subpackage Criteria
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Criteria extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('criteria');
	}
}

/* End of file Criteria.php */
/* Location : ./application/models/Criteria.php */