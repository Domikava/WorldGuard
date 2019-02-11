<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults\types;

use pocketmine\Player;

class ChatMessage implements MessageType{

	public const KEY_MESSAGE = "message";

	public static function getIdentifier() : string{
		return "chat";
	}

	/** @var string */
	protected $message;

	public function fromData(array $data) : void{
		$this->message = $data[self::KEY_MESSAGE];
	}

	public function toData() : array{
		return [
			self::KEY_MESSAGE => $this->message
		];
	}

	public function setMessage(string $message) : void{
		$this->message = $message;
	}

	public function send(Player $player, array $replace_pairs) : void{
		$player->sendMessage(strtr($this->message, $replace_pairs));
	}
}