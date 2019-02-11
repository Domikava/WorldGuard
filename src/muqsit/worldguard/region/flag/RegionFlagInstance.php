<?php

declare(strict_types=1);

namespace muqsit\worldguard\region\flag;

interface RegionFlagInstance{

	/**
	 * Returns the flag identifier/name. For example: if
	 * this flag denies block break, it might be named
	 * "block-break".
	 *
	 * @return string
	 */
	public static function getIdentifier() : string;

	/**
	 * Loads this flag's properties from data.
	 *
	 * @param array $data
	 */
	public function fromData(array $data) : void;

	/**
	 * Returns this flag's properties as an array.
	 *
	 * @return array
	 */
	public function toData() : array;
}