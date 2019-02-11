<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\defaults;

use muqsit\worldguard\region\BaseRegionInstance;

use pocketmine\math\Vector3;

class RectangularRegionInstance extends BaseRegionInstance{

	public const KEY_MINX = "minx";
	public const KEY_MINZ = "minz";
	public const KEY_MAXX = "maxx";
	public const KEY_MAXZ = "maxz";

	public static function getIdentifier() : string{
		return "rectangle";
	}

	/** @var int */
	protected $minX;

	/** @var int */
	protected $minZ;

	/** @var int */
	protected $maxX;

	/** @var int */
	protected $maxZ;

	public function valid() : bool{
		return parent::valid() &&
			$this->minX !== null && $this->maxX !== null &&
			$this->minZ !== null && $this->maxZ !== null;
	}

	public function setX(int $minX, int $maxX) : void{
		$this->minX = $minX;
		$this->maxX = $maxX;
	}

	public function setZ(int $minZ, int $maxZ) : void{
		$this->minZ = $minZ;
		$this->maxZ = $maxZ;
	}

	public function fromData(array $data) : void{
		parent::fromData($data);
		$this->minX = $data[self::KEY_MINX];
		$this->minZ = $data[self::KEY_MINZ];
		$this->maxX = $data[self::KEY_MAXX];
		$this->maxZ = $data[self::KEY_MAXZ];
	}

	public function toData() : array{
		$data = parent::toData();
		$data[self::KEY_MINX] = $this->minX;
		$data[self::KEY_MINZ] = $this->minZ;
		$data[self::KEY_MAXX] = $this->maxX;
		$data[self::KEY_MAXZ] = $this->maxZ;
		return $data;
	}

	public function contains(Vector3 $pos) : bool{
		return $pos->x >= $this->minX && $pos->x <= $this->maxX &&
			$pos->z >= $this->minZ && $pos->z <= $this->maxZ;
	}

	public function getChunks() : \Generator{
		$minChunkX = $this->minX >> 4;
		$maxChunkX = $this->maxX >> 4;
		$minChunkZ = $this->minZ >> 4;
		$maxChunkZ = $this->maxZ >> 4;

		for($chunkX = $minChunkX; $chunkX <= $maxChunkX; ++$chunkX){
			for($chunkZ = $minChunkZ; $chunkZ <= $maxChunkZ; ++$chunkZ){
				yield [$chunkX, $chunkZ];
			}
		}
	}
}