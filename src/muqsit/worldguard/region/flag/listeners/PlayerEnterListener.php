<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\listeners;

use muqsit\worldguard\region\RegionInstance;

use pocketmine\Player;

interface PlayerEnterListener{

	/**
	 * Called when a player enters the region.
	 *
	 * @param Player $player who entered
	 * @param RegionInstance $region they entered
	 *
	 * @return bool whether to allow the player to
	 * enter this region.
	 */
	public function onEnter(Player $player, RegionInstance $region) : bool;
}