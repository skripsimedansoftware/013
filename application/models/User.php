<?php
/**
 * @package Codeigniter
 * @subpackage User
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class User extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('user');
	}

	public function sign_in($identity, $password) {
		$this->db->group_start()
			->where('username', $identity)
			->or_group_start()
				->where('email', $identity)
			->group_end()
		->group_end();
		$this->db->where('password', sha1($password));
		return $this->db->get($this->table);
	}
}

/* End of file User.php */
/* Location : ./application/models/User.php */