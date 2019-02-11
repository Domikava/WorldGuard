<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults\types;

use pocketmine\utils\Utils;

final class Message{

	public const KEY_IDENTIFIER = "type";

	/** @var string[] */
	private static $messages = [];

	public static function registerDefaults() : void{
		self::register(ChatMessage::class);
		self::register(PopupMessage::class);
		self::register(TipMessage::class);
		self::register(TitleMessage::class);
	}

	public static function register(string $message) : void{
		Utils::testValidInstance($message, MessageType::class);

		if(isset(self::$messages[$identifier = $message::getIdentifier()])){
			throw new \InvalidArgumentException("A message with the identifier " . $identifier . " is already registered.");
		}

		self::$messages[$identifier] = $message;
	}

	public static function get(string $identifier) : MessageType{
		if(!isset(self::$messages[$identifier])){
			throw new \InvalidArgumentException("Invalid message type " . $identifier . " given.");
		}

		$class = self::$messages[$identifier];
		return new $class();
	}

	public static function fromData(array $data) : MessageType{
		$message = self::get($data[self::KEY_IDENTIFIER]);
		$message->fromData($data);
		return $message;
	}

	public static function toData(MessageType $message) : array{
		$data = $message->toData();
		$data[self::KEY_IDENTIFIER] = $message::getIdentifier();
		return $data;
	}
}