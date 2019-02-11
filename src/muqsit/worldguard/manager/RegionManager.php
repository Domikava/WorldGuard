<?php

declare(strict_types=1);

namespace muqsit\worldguard\manager;

use muqsit\worldguard\region\RegionInstance;

use pocketmine\level\Level;
use pocketmine\level\Position;

class RegionManager{

	/** @var RegionInstance[] */
	private $regions = [];

	/** @var LevelManager[] */
	private $level_managers = [];

	public function fromData(array $regions) : void{
		$this->regions = [];

		foreach($regions as $level_name => $manager){
			$this->createLevelManager($level_name)->fromData($manager);
		}
	}

	public function toData() : array{
		$result = [];

		foreach($this->level_managers as $level_name => $manager){
			$result[$level_name] = $manager->toData();
		}

		return $result;
	}

	public function getAt(Position $pos) : \Generator{
		$level_manager = $this->getLevelManager($pos->getLevel()->getFolderName());
		if($level_manager !== null){
			$chunk_manager = $level_manager->getChunkManager($pos->getFloorX() >> 4, $pos->getFloorZ() >> 4);
			if($chunk_manager !== null){
				foreach($chunk_manager->getRegions() as $region_name){
					$region = $this->get($region_name);
					if($region->contains($pos)){
						yield $region;
					}
				}
			}
		}
	}

	public function getAtDiff(Position $pos, Position ...$positions) : \Generator{
		foreach($this->getAt($pos) as $region){
			foreach($positions as $position){
				if($region->contains($position)){
					continue 2;
				}
			}

			yield $region;
		}
	}

	public function getAtIntersect(Position $pos, Position ...$positions) : \Generator{
		foreach($this->getAt($pos) as $region){
			foreach($positions as $position){
				if(!$region->contains($position)){
					continue 2;
				}
			}

			yield $region;
		}
	}

	public function get(string $name) : ?RegionInstance{
		return $this->regions[strtolower($name)] ?? null;
	}

	public function set(Level $level, RegionInstance $region) : void{
		if(!$region->valid()){
			throw new \InvalidArgumentException("Incomplete region data given for region.");
		}

		if(isset($this->regions[$key = strtolower($region->getName())])){
			throw new \InvalidArgumentException("A region with the name " . $region->getName() . " already exists!");
		}

		$this->regions[$key] = $region;
		$this->setInternal($level, $region);
	}

	public function unset(Level $level, RegionInstance $region) : void{
		if(!$region->valid()){
			throw new \InvalidArgumentException("Incomplete region data for region " . $region->getName() . " given.");
		}

		if(!isset($this->regions[$key = strtolower($region->getName())])){
			throw new \InvalidArgumentException("Region " . $region->getName() . " has not been set!");
		}

		unset($this->regions[$key]);
		$this->unsetInternal($level, $region);
	}

	private function createLevelManager(string $level_name) : LevelManager{
		if(isset($this->level_managers[$level_name])){
			throw new \InvalidArgumentException("A level manager with the name " . $level_manager . " already exists!");
		}

		return $this->level_managers[$level_name] = new LevelManager($level_name);
	}

	public function getLevelManager(string $level_name) : ?LevelManager{
		return $this->level_managers[$level_name] ?? null;
	}

	private function setInternal(Level $level, RegionInstance $region) : void{
		$level_name = $level->getFolderName();
		($this->getLevelManager($level_name) ?? $this->createLevelManager($level_name))->set($region);
	}

	private function unsetInternal(Level $level, RegionInstance $region) : void{
		$level_manager = $this->getLevelManager($level->getFolderName());
		if($level_manager !== null){
			$level_manager->unset($region);
		}
	}
}