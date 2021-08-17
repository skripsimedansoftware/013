<?php
/**
 * @package Codeigniter
 * @subpackage Admin
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Admin extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function masuk($identity, $password) {
		$this->db->where('username', $identity)->where('password', sha1($password));
		return $this->db->get('admin');
	}

	public function detail($where) {
		return $this->db->get_where('admin', $where);
	}
}

/* End of file Admin.php */
/* Location : ./application/models/Admin.php */