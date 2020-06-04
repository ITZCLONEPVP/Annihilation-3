<?php
declare(strict_types=1);
namespace annihilation\lib\scoreboard;
/*
 *	   _     _ _                          
 *	 | |   (_) |__  _ __ __ _ _ __ _   _ 
 *	 | |   | | '_ \| '__/ _` | '__| | | |
 *	 | |___| | |_) | | | (_| | |  | |_| |
 *	 |_____|_|_.__/|_|  \__,_|_|   \__, |
 *                               |___/ 
 * This is a library for my plugin
 * Author: NTT
 * Source: https://github.com/NTT1906/library
*/

use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\Player;

class Scoreboard{
	/** @var array $scoreboards */
	private $scoreboards = [];
	/** 
	  * Make new scoreboard
	  * Usage:
	  *	$scoreboard = new Scoreboard();
	  *	$scoreboard->new($player, string "Example", "Display");
      * @param Player $player The class of the player
      * @param string $objectiveName The name of the object
      * @param string $displayName The display name of the scoreboard
	 */
	public function new(Player $player, string $objectiveName, string $displayName): void{
		if(isset($this->scoreboards[$player->getName()])){
			$this->remove($player);
		}
		$pk = new SetDisplayObjectivePacket();
		$pk->displaySlot = "sidebar";
		$pk->objectiveName = $objectiveName;
		$pk->displayName = $displayName;
		$pk->criteriaName = "dummy";
		$pk->sortOrder = 0;
		$player->sendDataPacket($pk);
		$this->scoreboards[$player->getName()] = $objectiveName;
	}
	/** 
	  * Remove a scoreboard
	  * Usage:
	  *	$scoreboard->remove($player);
      * @param Player $player The class of the player
	 */
	public function remove(Player $player): void{
		$objectiveName = $this->getObjectiveName($player);
		$pk = new RemoveObjectivePacket();
		$pk->objectiveName = $objectiveName;
		$player->sendDataPacket($pk);
		unset($this->scoreboards[$player->getName()]);
	}
	/** 
	  * Add or set a new line in scoreboard
	  * Usage:
	  *	$scoreboard->setLine($player, 1, "Display");
      * @param Player $player The class of the player
      * @param int $score The line of the scoreboard
      * @param string $message The display message of the scoreboard
	 */
	public function setLine(Player $player, int $score, string $message): void{
		if(!isset($this->scoreboards[$player->getName()])){
			$this->getLogger()->error("Cannot set a score to a player with no scoreboard");
			return;
		}
		if($score > 15 || $score < 1){
			$this->getLogger()->error("Score must be between the value of 1-15. $score out of range");
			return;
		}
		$objectiveName = $this->getObjectiveName($player);
		$entry = new ScorePacketEntry();
		$entry->objectiveName = $objectiveName;
		$entry->type = $entry::TYPE_FAKE_PLAYER;
		$entry->customName = $message;
		$entry->score = $score;
		$entry->scoreboardId = $score;
		$pk = new SetScorePacket();
		$pk->type = $pk::TYPE_CHANGE;
		$pk->entries[] = $entry;
		$player->sendDataPacket($pk);
	}
	/** 
	  * Get objective name
	  * Usage:
	  *	$scoreboard->getObjectiveName($player);
      * @param Player $player The class of the player
      * @return string Return the name of the objective
	 */
	public function getObjectiveName(Player $player): ?string{
		return isset($this->scoreboards[$player->getName()]) ? $this->scoreboards[$player->getName()] : null;
	}
	/** 
	  * Remove objective when player left the server and
	 */
	public function onQuit(PlayerQuitEvent $event): void{
		if(isset($this->scoreboards[($player = $event->getPlayer()->getName())])) unset($this->scoreboards[$player]);
	}
}