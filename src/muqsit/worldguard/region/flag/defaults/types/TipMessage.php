<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults\types;

use pocketmine\Player;

class TipMessage extends ChatMessage{

	public static function getIdentifier() : string{
		return "tip";
	}

	public function send(Player $player, array $replace_pairs) : void{
		$player->sendTip(strtr($this->message, $replace_pairs));
	}
}