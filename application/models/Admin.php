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

	public function where($identity) {
		$this->db->group_start()
			->where('username', $identity)
			->or_group_start()
				->where('email', $identity)
			->group_end()
		->group_end();
		return $this->db->get('admin');
	}
}

/* End of file Admin.php */
/* Location : ./application/models/Admin.php */