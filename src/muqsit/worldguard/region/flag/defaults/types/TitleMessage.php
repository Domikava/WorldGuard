<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag\defaults\types;

use pocketmine\Player;

class TitleMessage implements MessageType{

	public const KEY_TITLE = "title";
	public const KEY_SUBTITLE = "subtitle";
	public const KEY_FADE_IN = "fadein";
	public const KEY_STAY = "stay";
	public const KEY_FADE_OUT = "fadeout";

	public static function getIdentifier() : string{
		return "title";
	}

	/** @var string */
	protected $title;

	/** @var string */
	protected $subtitle;

	/** @var int */
	protected $fadeIn = -1;

	/** @var int */
	protected $stay = -1;

	/** @var int */
	protected $fadeOut = -1;

	public function fromData(array $data) : void{
		$this->title = $data[self::KEY_TITLE];
		$this->subtitle = $data[self::KEY_SUBTITLE];
		$this->fadeIn = $data[self::KEY_FADE_IN];
		$this->stay = $data[self::KEY_STAY];
		$this->fadeOut = $data[self::KEY_FADE_OUT];
	}

	public function toData() : array{
		return [
			self::KEY_TITLE => $this->title,
			self::KEY_SUBTITLE => $this->subtitle,
			self::KEY_FADE_IN => $this->fadeIn,
			self::KEY_STAY => $this->stay,
			self::KEY_FADE_OUT => $this->fadeOut
		];
	}

	public function setTitle(string $title, string $subtitle = "", int $fadeIn = -1, int $stay = -1, int $fadeOut = -1) : void{
		$this->title = $title;
		$this->subtitle = $subtitle;
		$this->fadeIn = $fadeIn;
		$this->stay = $stay;
		$this->fadeOut = $fadeOut;
	}

	public function send(Player $player, array $replace_pairs) : void{
		$player->addTitle(strtr($this->title, $replace_pairs), strtr($this->subtitle, $replace_pairs), $this->fadeIn, $this->stay, $this->fadeOut);
	}
}