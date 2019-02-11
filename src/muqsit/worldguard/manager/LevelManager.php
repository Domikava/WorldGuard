<?php

declare(strict_types=1);

namespace muqsit\worldguard\manager;

use Ds\Set;

use muqsit\worldguard\region\Region;
use muqsit\worldguard\region\RegionInstance;

use pocketmine\level\Level;
use pocketmine\Server;

class LevelManager{

	/** @var string */
	private $level_name;

	/** @var Set<string> */
	private $regions;

	/** @var ChunkManager[] */
	private $chunk_managers = [];

	public function __construct(string $level_name){
		$this->level_name = $level_name;
		$this->regions = new Set();
	}

	public function fromData(RegionManager $manager, array $data) : void{
		foreach($data as $region_data){
			$manager->set(Region::fromData($region_data));
		}
	}

	public function toData(RegionManager $manager) : array{
		$data = [];

		foreach($this->regions as $region_name){
			$region = $manager->get($region_name);
			$data[strtolower($region->getName())] = $region->toData();
		}

		return $data;
	}

	public function getLevelInstance() : Level{
		return Server::getInstance()->getLevelManager()->getLevelByName($this->level_name);
	}

	public function set(RegionInstance $region) : void{
		if($this->regions->contains($key = strtolower($region->getName()))){
			throw new \InvalidArgumentException("A region with the name " . $region->getName() . " already exists!");
		}

		$this->regions->add($key);
		$this->setInternal($region);
	}

	public function unset(RegionInstance $region) : void{
		if(!$this->regions->contains($key = strtolower($region->getName()))){
			throw new \InvalidArgumentException("Region " . $region->getName() . " has not been set!");
		}

		$this->regions->remove($key);
		$this->unsetInternal($region);
	}

	private function createChunkManager(int $chunkX, int $chunkZ) : ChunkManager{
		if(isset($this->chunk_managers[$hash = Level::chunkHash($chunkX, $chunkZ)])){
			throw new \InvalidArgumentException("A chunk manager at " . $chunkX . "x, " . $chunkZ . "z already exists!");
		}

		return $this->chunk_managers[$hash] = new ChunkManager($chunkX, $chunkZ);
	}

	public function getChunkManager(int $chunkX, int $chunkZ) : ?ChunkManager{
		return $this->chunk_managers[Level::chunkHash($chunkX, $chunkZ)] ?? null;
	}

	private function setInternal(RegionInstance $region) : void{
		$key = strtolower($region->getName());
		foreach($region->getChunks() as [$chunkX, $chunkZ]){
			($this->getChunkManager($chunkX, $chunkZ) ?? $this->createChunkManager($chunkX, $chunkZ))->set($region);
		}
	}

	private function unsetInternal(RegionInstance $region) : void{
		$key = strtolower($region->getName());
		foreach($region->getChunks() as [$chunkX, $chunkZ]){
			$manager = $this->getChunkManager($chunkX, $chunkZ);
			if($manager !== null){
				$manager->unset($region);
			}
		}
	}
}