<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\defaults;

use muqsit\worldguard\region\BaseRegionInstance;

use pocketmine\math\Vector3;

class CuboidalRegionInstance extends RectangularRegionInstance{

	public const KEY_MINY = "miny";
	public const KEY_MAXY = "maxy";

	public static function getIdentifier() : string{
		return "cuboid";
	}

	/** @var int */
	protected $minY;

	/** @var int */
	protected $maxY;

	public function valid() : bool{
		return parent::valid() &&
			$this->minY !== null && $this->maxY !== null;
	}

	public function setY(int $minY, int $maxY) : void{
		$this->minY = $minY;
		$this->maxY = $maxY;
	}

	public function fromData(array $data) : void{
		parent::fromData($data);
		$this->minY = $data[self::KEY_MINY];
		$this->maxY = $data[self::KEY_MAXY];
	}

	public function toData() : array{
		$data = parent::toData();
		$data[self::KEY_MINY] = $this->minY;
		$data[self::KEY_MAXY] = $this->maxY;
		return $data;
	}

	public function contains(Vector3 $pos) : bool{
		return parent::contains($pos) &&
			$pos->y >= $this->minY && $pos->y <= $this->maxY;
	}
}