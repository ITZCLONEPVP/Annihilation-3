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
	/** @var Annihilation $plugin */
	public $plugin;
	
    /** @var ArenaScheduler $scheduler */
    public $scheduler;
	/** @var \annihilation\lib\formapi\FormAPI $formapi */
	public $formapi;
	/** @var \annihilation\lib\scordboard\Scoreboard $scoreboard */
	public $scoreboard;
   /** @var \annihilation\utils\Utils $utils */
    public $utils;
    /** @var LangManager $lang */
    public $lang;
    
    private $players = [];
    
    /** @var array $data */
    private $data = array();
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
		if(!$player instanceof Player) $player = $this->getPlayer($player);
		if($player->getLevel()->getName() != $this->data->level){
			if(isset($this->players[$player->getName()])) return true;
		}
		return false;
	}
}