<?php

namespace Algorithm\SAW;

class Alternative
{
	private $data = array();

	public function add(array $data, $criteria, $key = NULL)
	{
		if (strlen($key) <= 0)
		{
			$key = count($this->data) > 0 ? count($this->data) + 1 - 1 : 0;
		}

		$this->data[$key] = array(
			'data' => $data,
			'criteria' => $criteria
		);

		return $this;
	}

	public function get($key = NULL)
	{
		if (strlen($key) > 0)
		{
			return $this->data[$key];
		}
		else
		{
			return $this->data;
		}
	}
}