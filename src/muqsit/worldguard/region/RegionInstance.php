<?php

declare(strict_types=1);

namespace muqsit\worldguard\region;

use muqsit\worldguard\region\flag\RegionFlagHolder;

use pocketmine\math\Vector3;

interface RegionInstance{

	public const KEY_NAME = "name";
	public const KEY_FLAGS = "flags";

	/**
	 * Returns the region identifier. For example: if
	 * this is a cuboidal region, this would return
	 * "cuboid".
	 *
	 * @return string
	 */
	public static function getIdentifier() : string;

	/**
	 * Returns the unique name given to this
	 * region.
	 *
	 * @return string
	 */
	public function getName() : string;

	/**
	 * Returns all chunks this region is intersecting.
	 *
	 * @return \Generator<int[]>
	 */
	public function getChunks() : \Generator;

	/**
	 * Returns whether a 3D point lies inside this
	 * region.
	 *
	 * @param Vector3 $pos
	 *
	 * @return bool
	 */
	public function contains(Vector3 $pos) : bool;

	/**
	 * Validates the properties of this region and
	 * returns whether this is a valid region.
	 *
	 * @return bool
	 */
	public function valid() : bool;

	/**
	 * Loads this region's properties from data.
	 *
	 * @param array $data
	 */
	public function fromData(array $data) : void;

	/**
	 * Returns this region's properties as an array.
	 *
	 * @return array
	 */
	public function toData() : array;

	/**
	 * Returns a RegionFlagHolder for this region.
	 *
	 * @return RegionFlagHolder
	 */
	public function getFlags() : RegionFlagHolder;
}