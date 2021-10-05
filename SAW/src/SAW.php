<?php

namespace Algorithm;

use Algorithm\SAW\Criteria;
use Algorithm\SAW\Alternative;

class SAW
{
	private $criteria;
	private $alternative;

	public function __construct()
	{
		$this->criteria = new Criteria;
		$this->alternative = new Alternative;
	}

	public function addCriteria(...$options)
	{
		return $this->criteria->add(...$options);
	}

	public function getCriteria()
	{
		return $this->criteria;
	}

	public function matrix_x()
	{
		return $this->alternative->get();
	}

	public function addAlternative(...$options)
	{
		return $this->alternative->add(...$options);
	}

	public function getAlternative()
	{
		return $this->alternative;
	}
}