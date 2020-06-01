<?php
declare(strict_types=1);
namespace animation;

use annihilation\arena\Arena;

/**
 * Class EmptyArenaChooser
 * @package vixikhd\thebridge
 */
class EmptyArenaChooser {
	/** @var Dragons $plugin */
	public $plugin;

	/**
 	* RandomArenaChooser constructor.
 	* @param Dragons $plugin
	 */
	public function __construct(Dragons $plugin) {
		$this->plugin = $plugin;
	}

/**
 * @return null|Arena
 */
public function getRandomArena(): ?Arena{
foreach($this->plugin->arenas as $index => $arena){
if($arena->scheduler->phase == 0 || $arena->scheduler->startTime <= 6){
$arenasByPlayers = [];
foreach ($availableArenas as $index => $arena) {
$arenasByPlayers[$index] = count($arena->players);
}
unset($availableArenas[$index]);
}
// searching by players

//1.

/** @var Arena[] $availableArenas */
$availableArenas = [];
foreach ($this->plugin->arenas as $index => $arena) {
$availableArenas[$index] = $arena;
}

//2.
foreach ($availableArenas as $index => $arena) {

}

//3.


arsort($arenasByPlayers);
$top = -1;
$availableArenas = [];

foreach ($arenasByPlayers as $index => $players) {
if($top == -1) {
$top = $players;
$availableArenas[] = $index;
}
else {
if($top == $players) {
$availableArenas[] = $index;
}
}
}

if(empty($availableArenas)) {
return null;
}

return $this->plugin->arenas[$availableArenas[array_rand($availableArenas, 1)]];
}
}