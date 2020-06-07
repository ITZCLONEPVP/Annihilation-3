<?php
declare(strict_types=1);
namespace annihilation\arena;
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

use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use annihilation\Annihilation;
use annihilation\utils\LangManager;
use annihilation\kit\KitManager;
use annihilation\event\ArenaRestartEvent;
use annihilation\math\Time;

class RandomArenaChooser {
	/** Arena Phase Id */
	const PHASE_WAIT = 0;
	const PHASE_GAME_1 = 1;
	const PHASE_GAME_2 = 2;
	const PHASE_GAME_3 = 3;
	const PHASE_GAME_4 = 4;
	const PHASE_GAME_5 = 5;
	const PHASE_RESTART = 6;
	/** Point id */
	const KILL_POINT = 0;
	const WIN_POINT = 1;
	const JOIN_POINT = 2;
	const DEATH_POINT = 3;
	/** Team colour ids*/
	private const TEAM_BASE_DATA = [
		"red" => [
			"name" => "Red",
			"colour" => "§c",
			"sub-colour" => "§4",
			"armor-colour-decimal" => "11141120",
		],
		"blue" => [
			"name" => "Blue",
			"colour" => "§9",
			"sub-colour" => "§1",
			"armor-colour-decimal" => "170",
		],
		"green" => [
			"name" => "Green",
			"colour" => "§a",
			"sub-colour" => "§2",
			"armor-colour-decimal" => "5635925",
		],
		"yellow" => [
			"name" => "Yellow",
			"colour" => "§e",
			"sub-colour" => "§6",
			"armor-colour-decimal" => "16777045",
		],
	];
	/** @var Annihilation $plugin */
	public $plugin;
	
    /** @var ArenaScheduler $scheduler */
    public $scheduler;
	/** @var \annihilation\lib\formapi\FormAPI $formapi */
	public $formapi;
	/** @var \annihilation\lib\scordboard\Scoreboard $scoreboard */
	public $scoreboard;
   /** @var \annihilation\utils\Utils $utils */
    public $utils = null;
    /** @var LangManager $lang */
    public $lang;
    /** @var array[] $player */
    public $players = array(); 
    /** @var array[] $data */
    public $data = array();    
    /** @var array[] $kits */
    public $kits = array();
    /** @var array[] $phase */
    public $phase = 0;
    /** @var array[] $points */
    public $points = array();
	/**
 	* Arena constructor.
 	* @param Annihilation $plugin
 	* @param array $data
	 */
	public function __construct(Annihilation $plugin, array $data){
		$this->plugin = $plugin;
		$this->data = $data;
		$this->formapi = $plugin->formapi;
		$this->lang = $plugin->getLang();
		$this->utils = $plugin->getUtils();
	}
	
	public function getKit($player) : bool{
		if(!$player instanceof Player){
			$player = $this->getPlayer($player);
			if($player != null) $player = $this->getPlayer($player);
			return false;
		}
		$armor_inv = $player->getArmorInventory();
		$array_map(array(self, "setLeatherAmrorCoulor"), $this->armor_inv->getContents());
	}
	
	public function setLeatherAmrorCoulor($item, $team) : bool{
		if(!in_array($item->getId(), [Item::LEATHER_CAP, Item::LEATHER_CHESTPLATE, Item::LEATHER_LEGGINGS, Item::LEATHER_BOOTS]) && !in_array(strtolower($team))) return false;
		$rgb = $this->utils->dec2Rgb(self::TEAM_BASE_DATA[strtolower($team)]["armor-colour-decimal"]);
		$colour = new Colour($rgb[0], $rgb[1], $rgb[2]);
		$item->setCustomColor($colour);
		return true;
	}
		
	public function getPlayer(string $name){
		if($player = $this->plugin->getServer()->getPlayer($name) == null) $player = $this->plugin->getServer()->getPlayerExact($name);
		return $this->inGame($player) ? $player : null;
	}
	
	public function getPlayers(){
		$results = array();
		foreach($this->players as $name => $data){
			$results[$name] = $this->getPlayer($name);
		}
		return $results;
		//return array_map(array(self, "getPlayer"), $this->players...
	}
	
	public function inGame($player) : bool{
		if(!$player instanceof Player){
			$player = $this->getPlayer($player);
			if($player != null) $player = $this->getPlayer($player);
			return false;
		}
		if($player->getLevel()->getName() != $this->data->level){
			if(isset($this->players[$player->getName()])) return true;
		}
		return false;
	}
	
	public function addPoint($player, int $pointType) : bool{
		if(!$player instanceof Player){
			$player = $this->getPlayer($player);
			if($player != null) $player = $this->getPlayer($player);
			return false;
		}
		if(!isset($this->points[$player->getName()])) $this->points[$player->getName()] = ["kill" => 0, "win" => 0, "join" => 0, "death" => 0];
		switch($pointType){
			case self::KILL_POINT: $this->points[$player->getName()]["kill"]++; break;
			case self::WIN_POINT: $this->points[$player->getName()]["win"]++; break; // This is for config ???
			case self::JOIN_POINT: $this->points[$player->getName()]["join"]++; break;
			case self::DEATH_POINT: $this->points[$player->getName()]["death"]++; break;
			default: break;
		}
		return true;
	}
}
