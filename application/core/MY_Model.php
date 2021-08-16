<?php
/**
 * @package Codeigniter
 * @subpackage Model
 * @category Libraries
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class MY_Model extends \CI_Model
{
	protected $db;

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database(ACTIVE_DATABASE_GROUP, TRUE);
	}

	/**
	 * Set database
	 */
	public function set_db($db_group = ACTIVE_DATABASE_GROUP)
	{
		$this->db = $this->load->database($db_group, TRUE);
	}

	/**
	 * Get database tables
	 * 
	 * @return array
	 */
	public function get_tables()
	{
		return $this->db->list_tables();
	}

	/**
	 * Table exists
	 * 
	 * @param  string $table
	 * @return boolean
	 */
	public function table_exists($table)
	{
		return $this->db->table_exists($table);
	}

	/**
	 * Get fields
	 * 
	 * @param  string $table
	 * @return array
	 */
	public function get_fields($table)
	{
		if ($this->db->table_exists($table))
		{
			return $this->db->list_fields($table);
		}

		return FALSE;
	}

	/**
	 * Field exists
	 * 
	 * @param  string $table
	 * @param  string $field
	 * @return boolean
	 */
	public function field_exists($table, $field)
	{
		if ($this->table_exists($table))
		{
			return $this->db->field_exists($field, $table);
		}

		return FALSE;
	}
}

/* End of file MY_Model.php */
/* Location : ./application/core/MY_Model.php */