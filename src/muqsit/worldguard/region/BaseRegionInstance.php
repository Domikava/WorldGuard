<?php

declare(strict_types=1);

namespace muqsit\worldguard\region;

use muqsit\worldguard\region\flag\RegionFlagHolder;

abstract class BaseRegionInstance implements RegionInstance{

	/** @var string */
	protected $name;

	/** @var RegionFlagHolder */
	protected $flags;

	public function __construct(){
		$this->flags = new RegionFlagHolder();
	}

	public function getFlags() : RegionFlagHolder{
		return $this->flags;
	}

	public function getName() : string{
		return $this->name;
	}

	public function setName(string $name) : void{
		$this->name = $name;
	}

	public function valid() : bool{
		return $this->name !== null;
	}

	public function fromData(array $data) : void{
		$this->name = $data[self::KEY_REGION_NAME];
		$this->flags->fromData($data[self::KEY_FLAGS]);
	}

	public function toData() : array{
		return [
			self::KEY_NAME => $this->name,
			self::KEY_FLAGS => $this->flags->toData()
		];
	}
}