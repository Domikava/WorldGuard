<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults\types;

use pocketmine\Player;

class PopupMessage extends ChatMessage{

	public static function getIdentifier() : string{
		return "popup";
	}

	public function send(Player $player, array $replace_pairs) : void{
		$player->sendPopup(strtr($this->message, $replace_pairs));
	}
}