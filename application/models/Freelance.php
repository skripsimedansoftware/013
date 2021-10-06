<?php
/**
 * @package Codeigniter
 * @subpackage Freelance
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Freelance extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('freelance');
	}
}

/* End of file Freelance.php */
/* Location : ./application/models/Freelance.php */