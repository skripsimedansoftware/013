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

	protected $table;

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

	/**
	 * Set table name
	 *
	 * @param      string  $table  Table name
	 */
	public function set_table($table)
	{
		$this->table = $table;
	}

	/**
	 * Create data
	 *
	 * @param      array   $data
	 * @return     object
	 */
	public function create($data = array())
	{
		return $this->db->insert($this->table, $data);
	}

	/**
	 * View data
	 *
	 * @param      array    $where   Where query
	 * @param      int  	$limit   The limit
	 * @param      int      $offset  The offset
	 * @return     object
	 */
	public function view($where = array(), $limit = NULL, $offset = 0)
	{
		if (!empty($where))
		{
			$this->db->where($where);
		}

		if (!empty($limit))
		{
			$this->db->limit($limit, $offset);
		}

		return $this->db->get($this->table);
	}

	/**
	 * Update data
	 *
	 * @param      array   $data   The data
	 * @param      array   $where  The where
	 * @return     object
	 */
	public function update(array $data, $where = array())
	{
		if (!empty($where))
		{
			$this->db->where($where);
		}

		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete data
	 *
	 * @param      array   $where  The where
	 * @return     object
	 */
	public function delete($where = array())
	{
		if (!empty($where))
		{
			$this->db->where($where);
		}

		return $this->db->delete($this->table);
	}
}

/* End of file MY_Model.php */
/* Location : ./application/core/MY_Model.php */