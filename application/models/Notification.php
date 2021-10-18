<?php
/**
 * @package Codeigniter
 * @subpackage Notification
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Notification extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('notification');
	}
}

/* End of file Notification.php */
/* Location : ./application/models/Notification.php */