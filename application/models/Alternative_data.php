<?php
/**
 * @package Codeigniter
 * @subpackage Alternative_data
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Alternative_data extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('alternative_data');
	}
}

/* End of file Alternative_data.php */
/* Location : ./application/models/Alternative_data.php */