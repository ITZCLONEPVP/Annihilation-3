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

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use annihilation\utils\Utils;

class Annihilation{
	/** @var array[] */
	private const BASE_DATA=[
		"prefix" => "Annihilation",
		"waiting-level" => "",
		"leaderboard" => [
			"win-position" => "",
			"kill-position" => "",
			"line-format" => "{top}-{player}: {point}",
		],
		"phase" => [
			"arena-phase-0" => "Waiting",
			"arena-phase-0-id" => "0",
			"arena-phase-1" => "",
			"arena-phase-1-id" => "I",
			"arena-phase-2" => "",
			"arena-phase-2-id" => "II",
			"arena-phase-3" => "",
			"arena-phase-3-id" => "III",
			"arena-phase-4" => "",
			"arena-phase-4-id" => "IV",
			"arena-phase-5" => "",
			"arena-phase-5-id" => "V",
		],
		"sign" => [
			"custom" => false,
			"arena-sign-prefix" => "Annihilation",
			"arena-sign-phase" => "Phase {id}",
			"arena-sign-map" => "Map: {level}",
			"arena-sign-stat" => "[{now}/{max}]"
		],
		"kits" => [
			"custom" => false,
			"kits-title" => "Annihilation Kits",
			"kits-subtitle" => "Tap the button!",
			"kits-possible" => "{green}{desc}",
			"kits-impossible" => "{gray}{desc}",
			"kits-name" => "{name}",
			"kits-money" => "{value}$",
			"kits-button" => "{kit-name} -=- {money}",
			"kits-button-subline" => "{kit-contents}",
			"#You can remove {prefix} for no prefix",
			"kits-message-not-enough" => "{prefix} You need more",
		],
		"messages" => [],
		"point" => [
			"kill" => 0,
			"join" => 0,
			"win" => 0,
		],
		"joins" => [
			"custom" => false,
			"join-title" => "Join Annihilation",
			"join-subtitle" => "Tap the button!",
			"join-possible" => "{green}{desc}",
			"join-impossible" => "{gray}{desc}",
			"join-button" => "{arena-name} -=- {now}/{max}",
			"join-button-subline" => "{arena-status}",
			"#You can remove {prefix} for no prefix",
			"join-message-arena-join" => "{prefix} You joined {arena-name} Map!",
			"join-message-arena-running" => "{prefix} {arena-name} is running now!",
			"join-message-arena-incompleted" => "{prefix} {arena-name} is incompleted!",
			"join-message-arena-restarting" => "{prefix} {arena-name} is restarting now!",
		],
	];
	
	private const BASE_GAME_LANG = [
		"arena-missing-player" => "You need more player to start the game! ({here}/{max})",
		"arena-full-player-message" => "Arena is full",
		"arena-team-full" => "{team} team is full!",
	];
	private const SYSTEM_LANG=[
		"plugin-enabled-success" => "{plugin} is enabled!",
		"plugin-disabled-success" => "{plugin} is disabled!",
		"plugin-missing-plugin" => "{plugin} is missing!",
		"plugin-download-plugin" => "{plugin} is downloading!",
		"plugin-enable-plugin" => "{plugin} is enabled!",
		"plugin-enable-plugin-error" => "{plugin} had failed to install! Searching its library...",
		"plugin-found-library-plugin" => "{plugin} had been found! We will use it for the feature!",
		"plugin-notice-outdated-config" => "{config} had outdated to use! Updates it to continue or set auto-updater to 1 in {config}",
		"plugin-notice-updated-config" => "{config} had updated for more features! This is the changelog: {changelog}",
		"plugin-message-bug" => "If you found anybug, makes an issue on {link}",
		"plugin-log-error" => "There were an error! Please try again!",
	];
	private const GAME_LANG = [];
	private $data;
	private $plugin_path;
	private $utils;
	private $language;
	
	public function onEnabled(){
		$this->setUp();
	}
	
	public function setUp(){
		if(!file_exists($this->setPluginPath())) @mkdir($this->plugin_path, 0777);
		$language = $this->getUtils()->yml2Array(//Todo);
		$this->language = new LangManager(self::GAME_LANG);
	}
	
	public function getUtils(){
		return $this->utils !== null ? $this->utils : new Utils($this);
	}
		
	
	public function setPluginPath(string $path = null){
		if($path == null){
			$this->plugin_path = $this->getServer()->getDataPath() . $this->getName() . "/";
		}else{
			$this->plugin_path = $path;
		}
		return $this->plugin_path;
	}
	
	public function getPluginPath(){
		return !is_null($this->plugin_path) ? $this->plugin_path : $this->getServer()->getDataFolder() . $this->getName() . "/";
	}
	
	public function getLang(){
		return $this->language !== null ? $this->language : new LangManager(self::GAME_LANG);
	}
	
	public function getPluginData(){
		return $this->data !== null ? $this->data : $this->getPluginDataFile();
	}
	
	public function getPluginDataFile(){
		$result = $this->yml2Array(file_get_contents($this->getPluginPath . "data.yml"));
		return !is_null($result) ? $result : self::BASE_DATA;
	}
	
	public function savePluginData(){
		$this->array2Yml($this->getPluginData(), $this->getPluginPath . "data.yml");
	}
	
	public function saveGameData(){
		$this->getAreans();
	}
	
	public function getArenas(){
		
	}
	
	public function log(string $log, $level= "info", bool $prefix = false){
		$int_values = [0, 1, 2, 3, 4, 5, 6, 7];
		$string_values = ["emergency","alert", "critical", "error", "warning", "notice", "info", "debug"];
		$level = str_ireplace($int_values, $string_values, $level);
		if(!in_array($level, $string_values)){
			$this->log(self::SYSTEM_LANG["plugin-log-error"], "alert");
		}else{
			$this->log($level, $log);
		}
	}
	
	public function onDisabled(){
	}
}