<?php
declare(strict_types=1);
namespace annihilation/kit/defaults;

use pocketmine\Player;

/**
 * Interface Kit
 * @package vixikhd\dragons\kit\defaults
 */
interface Kit{
	public $contents;
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param Player $player
     */
    public function sendKitContents(Player $player): void;

    /**
     * @return string
     */
    public function getDescription(): string;
}