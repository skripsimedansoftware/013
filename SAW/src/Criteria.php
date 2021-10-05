<?php

namespace Algorithm\SAW;

class Criteria
{
	private $data = array();

	public function add($attribute, $weight, $name = '-', $key = NULL)
	{
		if (strlen($key) <= 0)
		{
			$key = count($this->data) > 0 ? count($this->data) + 1 - 1 : 0;
		}

		$this->data[$key] = array(
			'name' => $name,
			'weight' => $weight,
			'attribute' => $attribute,
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