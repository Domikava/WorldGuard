<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults\types;

use pocketmine\Player;

interface MessageType{

	/**
	 * Returns the type of message this is. For example:
	 * if this is a popup, this would return "popup";
	 */
	public static function getIdentifier() : string;

	/**
	 * Loads this message's properties from data.
	 *
	 * @param array $data
	 */
	public function fromData(array $data) : void;

	/**
	 * Returns this message's properties as an array.
	 *
	 * @return array
	 */
	public function toData() : array;

	/**
	 * Sends player this message.
	 *
	 * @param Player $player
	 */
	public function send(Player $player, array $replace_pairs) : void;
}