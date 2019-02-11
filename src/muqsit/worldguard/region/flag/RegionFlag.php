<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag;

use muqsit\worldguard\region\flag\defaults\EnterMessageFlag;
use muqsit\worldguard\region\flag\defaults\ExitMessageFlag;

use pocketmine\utils\Utils;

final class RegionFlag{

	public const KEY_IDENTIFIER = "identifier";

	/** @var string[] */
	private static $flags = [];

	public static function registerDefaults() : void{
		self::register(EnterMessageFlag::class);
		self::register(ExitMessageFlag::class);
	}

	public static function register(string $instance) : void{
		Utils::testValidInstance($instance, RegionFlagInstance::class);

		if(isset(self::$flags[$identifier = $instance::getIdentifier()])){
			throw new \InvalidArgumentException("A flag with the identifier " . $identifier . " is already registered.");
		}

		self::$flags[$identifier] = $instance;
	}

	public static function get(string $identifier) : RegionFlagInstance{
		if(!isset(self::$flags[$identifier])){
			throw new \InvalidArgumentException("Invalid flag type " . $identifier . " given.");
		}

		$class = self::$flags[$identifier];
		return new $class();
	}
}