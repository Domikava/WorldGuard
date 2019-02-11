<?php

declare(strict_types=1);

namespace muqsit\worldguard;

use muqsit\worldguard\manager\RegionManager;
use muqsit\worldguard\region\Region;
use muqsit\worldguard\region\flag\RegionFlag;
use muqsit\worldguard\region\flag\defaults\types\Message;

use pocketmine\plugin\PluginBase;

class WorldGuard extends PluginBase{

	public const REGIONS_FILE = "regions.yml";

	/** @var RegionManager */
	private $region_manager;

	public function onEnable() : void{
		Message::registerDefaults();
		RegionFlag::registerDefaults();
		Region::registerDefaults();

		$this->region_manager = new RegionManager();
		$this->loadRegions();

		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this->getRegionManager()), $this);

		$region = Region::get("rectangle");
		$region->setName("Test");
		$region->setX(0, 15);
		$region->setZ(0, 31);

		$flag = RegionFlag::get("enter-message");
		$message = Message::get("popup");
		$message ->setMessage("Hey {PLAYER}! You entered {REGION}");
		$flag->setMessage($message);
		$region->getFlags()->set($flag);

		$flag = RegionFlag::get("exit-message");
		$message = Message::get("popup");
		$message->setMessage("Hey {PLAYER}! You left {REGION}");
		$flag->setMessage($message);
		$region->getFlags()->set($flag);

		$this->getRegionManager()->set($this->getServer()->getLevelManager()->getDefaultLevel(), $region);

var_dump($this->getRegionManager());
	}

	public function onDisable() : void{
		//$this->saveRegions();
	}

	public function getRegionManager() : RegionManager{
		return $this->region_manager;
	}

	public function loadRegions() : void{
		$this->saveResource(self::REGIONS_FILE);
		$this->getRegionManager()->fromData(yaml_parse_file($this->getDataFolder() . self::REGIONS_FILE));
	}

	public function saveRegions() : void{
		yaml_emit_file($this->getDataFolder() . self::REGIONS_FILE, $this->getRegionManager()->toData());
	}
}
