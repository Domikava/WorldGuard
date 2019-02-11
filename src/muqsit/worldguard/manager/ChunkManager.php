<?php

declare(strict_types=1);

namespace muqsit\worldguard\manager;

use Ds\Set;

use muqsit\worldguard\region\RegionInstance;

class ChunkManager{

	/** @var int */
	private $chunkX;

	/** @var int */
	private $chunkZ;

	/** @var Set<string> */
	private $regions;

	public function __construct(int $chunkX, int $chunkZ){
		$this->chunkX = $chunkX;
		$this->chunkZ = $chunkZ;
		$this->regions = new Set();
	}

	public function set(RegionInstance $region) : void{
		if($this->regions->contains($key = strtolower($region->getName()))){
			throw new \InvalidArgumentException("A region with the name " . $region->getName() . " already exists!");
		}

		$this->regions->add($key);
	}

	public function unset(RegionInstance $region) : void{
		if(!$this->regions->contains($key = strtolower($region->getName()))){
			throw new \InvalidArgumentException("Region " . $region->getName() . " has not been set!");
		}

		$this->regions->remove($key);
	}

	public function getRegions() : \Generator{
		yield from $this->regions;
	}
}