<?php

declare(strict_types=1);

namespace muqsit\worldguard;

use muqsit\worldguard\manager\RegionManager;
use muqsit\worldguard\region\flag\listeners\PlayerEnterListener;
use muqsit\worldguard\region\flag\listeners\PlayerExitListener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class EventListener implements Listener{

	/** @var RegionManager */
	private $region_manager;

	public function __construct(RegionManager $region_manager){
		$this->region_manager = $region_manager;
	}

	/**
	 * @param PlayerMoveEvent $event
	 * @priority HIGH
	 * @ignoreCancelled true
	 */
	public function onPlayerMove(PlayerMoveEvent $event) : void{
		$player = $event->getPlayer();
		$from = $event->getFrom();
		$to = $event->getTo();

		if($from->floor()->equals($to->floor())){
			return;
		}

		foreach($this->region_manager->getAtDiff($from, $to) as $region){
			foreach($region->getFlags()->getAll() as $flag){
				if($flag instanceof PlayerExitListener && !$flag->onExit($player, $region)){
					$event->setCancelled();
					return;
				}
			}
		}

		foreach($this->region_manager->getAtDiff($to, $from) as $region){
			foreach($region->getFlags()->getAll() as $flag){
				if($flag instanceof PlayerEnterListener && !$flag->onEnter($player, $region)){
					$event->setCancelled();
					return;
				}
			}
		}
	}
}