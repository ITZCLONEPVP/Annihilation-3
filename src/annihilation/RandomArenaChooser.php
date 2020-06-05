<?php
declare(strict_types=1);
namespace annihilation;
/**
 *	     _                _ _     _ _       _   _             
 *	    / \   _ __  _ __ (_) |__ (_) | __ _| |_(_) ___  _ __  
 *	   / _ \ | '_ \| '_ \| | '_ \| | |/ _` | __| |/ _ \| '_ \ 
 *	  / ___ \| | | | | | | | | | | | | (_| | |_| | (_) | | | |
 *	 /_/   \_\_| |_|_| |_|_|_| |_|_|_|\__,_|\__|_|\___/|_| |_|                                                         
 * This plugin is free plugin for PocketMine or Foxel Server
 * @author NTT
 * @link http://github.com/NTT1906
 *
*/

use annihilation\arena\Arena;

class RandomArenaChooser {
	/** @var Annihilation $plugin */
	public $plugin;

	/**
 	* RandomArenaChooser constructor.
 	* @param Annihilation $plugin
	 */
	public function __construct(Annihilation $plugin) {
		$this->plugin = $plugin;
	}
	/**
 	* @return Arena $arena
	 */
	public function getRandomArena() : ?Arena{
		$arenas = $this->plugin->getArenas();
		$arenasByPlayers = [];
		foreach($arenas as $index => $arena){
			if($arena->scheduler->phase == 0 || $arena->scheduler->startTime >= 6){
				if($arena->data["enabled"]) $arenasByPlayers[] = $arena;
			}
		}
		return $arenas[array_rand($arenasByPlayer, 1)];
	}
}