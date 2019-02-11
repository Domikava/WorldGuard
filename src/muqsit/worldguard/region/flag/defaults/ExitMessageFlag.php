<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults;

use muqsit\worldguard\region\flag\listeners\PlayerExitListener;
use muqsit\worldguard\region\flag\RegionFlagInstance;
use muqsit\worldguard\region\flag\defaults\types\Message;
use muqsit\worldguard\region\flag\defaults\types\MessageType;
use muqsit\worldguard\region\RegionInstance;

use pocketmine\Player;

class ExitMessageFlag implements RegionFlagInstance, PlayerExitListener{

	public const KEY_MESSAGE = "message";

	public const TRANSLATE_PLAYER = "{PLAYER}";
	public const TRANSLATE_REGION = "{REGION}";

	public static function getIdentifier() : string{
		return "exit-message";
	}

	/** @var MessageType */
	protected $message;

	public function setMessage(MessageType $message) : void{
		$this->message = $message;
	}

	public function fromData(array $data) : void{
		$this->message = Message::fromData($data[self::KEY_MESSAGE]);
	}

	public function toData() : array{
		return [
			self::KEY_MESSAGE => Message::toData($this->message)
		];
	}

	public function onExit(Player $player, RegionInstance $region) : bool{
		$this->message->send($player, [
			self::TRANSLATE_PLAYER => $player->getName(),
			self::TRANSLATE_REGION => $region->getName()
		]);

		return true;
	}
}