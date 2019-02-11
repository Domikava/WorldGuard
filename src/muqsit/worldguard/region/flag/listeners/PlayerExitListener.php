<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\listeners;

use muqsit\worldguard\region\RegionInstance;

use pocketmine\Player;

interface PlayerExitListener{

	/**
	 * Called when a player exits the region.
	 *
	 * @param Player $player who exited
	 * @param RegionInstance $region they exited
	 *
	 * @return bool whether to allow the player to
	 * exit this region.
	 */
	public function onExit(Player $player, RegionInstance $region) : bool;
}
