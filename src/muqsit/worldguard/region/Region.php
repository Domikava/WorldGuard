<?php

declare(strict_types=1);

namespace muqsit\worldguard\region;

use muqsit\worldguard\region\defaults\CuboidalRegionInstance;
use muqsit\worldguard\region\defaults\RectangularRegionInstance;

use pocketmine\utils\Utils;

final class Region{

	public const KEY_IDENTIFIER = "identifier";

	/** @var string[] */
	private static $regions = [];

	public static function registerDefaults() : void{
		self::register(CuboidalRegionInstance::class);
		self::register(RectangularRegionInstance::class);
	}

	public static function register(string $instance) : void{
		Utils::testValidInstance($instance, RegionInstance::class);

		if(isset(self::$regions[$identifier = $instance::getIdentifier()])){
			throw new \InvalidArgumentException("A region with the identifier " . $identifier . " is already registered.");
		}

		self::$regions[$identifier] = $instance;
	}

	public static function get(string $identifier) : RegionInstance{
		if(!isset(self::$regions[$identifier])){
			throw new \InvalidArgumentException("Invalid region type " . $identifier . " given.");
		}

		$class = self::$regions[$identifier];
		return new $class();
	}

	public static function fromData(array $data) : RegionInstance{
		$region = self::get($data[self::KEY_IDENTIFIER]);
		unset($data[self::KEY_IDENTIFIER]);
		$region->fromData($data);
		return $region;
	}

	public static function toData(RegionInstance $region) : array{
		$data = $region->toData();
		$data[self::KEY_IDENTIFIER] = $region::getIdentifier();
		return $data;
	}
}