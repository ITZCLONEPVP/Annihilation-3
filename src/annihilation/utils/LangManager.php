<?php
declare(strict_types=1);
namespace annihilation\utils;
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
use annihilation\Annihilation;
class LangManager{
	public $plugin;
	public $utils;
	public $default = "en";
	const LANGUAGE_IDS = [
		"en" => 0,
		"vi" => 1,
	];
	
	public function __construct(Annihilation $plugin, $language_id){
		$this->plugin = $plugin;
		$this->utils = $plugin->getUtils();
	}
	
	/*public function getLanguageFilePath($id){
		if(is_numeric($id)){
		
		return $this->plugin->getLangPath() . ;
	};
	
	public function getValue($key, $lang_id = 0){
		$this->utils->get($key, $lang_id);
		return;
	}
	
	public function isLanguageId($id) : bool{
		return in_array($id, self::LANGUAGE_IDS) ? true : false;
	}
	
	public static function translateString(int $from, int $to, string $string){
		//Todo
	}
	
	public function transcript($from, $to, string $string) : string{
		return Utils()::transcript($from, $to, string $string);
	}
	
	public function */
}