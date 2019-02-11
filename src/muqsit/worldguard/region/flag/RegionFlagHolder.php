<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag;

class RegionFlagHolder{

	/** @var RegionFlagsInstance[] */
	private $flags = [];

	public function fromData(array $data) : void{
		foreach($data as $identifier => $flag){
			$flag = RegionFlag::get($identifier);
			$flag->fromData($flag);
			$this->setFlag($flag);
		}
	}

	public function toData() : array{
		$data = [];

		foreach($this->flags as $flag){
			$data[$flag::getIdentifier()] = $flag->toData();
		}

		return $data;
	}

	public function set(RegionFlagInstance $instance) : void{
		$this->flags[$instance::getIdentifier()] = $instance;
	}

	public function remove(RegionFlagInstance $instance) : void{
		unset($this->flags[$instance::getIdentifier()]);
	}

	public function getAll() : array{
		return $this->flags;
	}
}