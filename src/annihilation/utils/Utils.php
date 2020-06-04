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

class Utils{
	/** @var Annihilation $plugin */
	public $plugin;
	/**
 	* Utils constructor.
 	* @param Annihilation $plugin
	 */
	public function __construct(Annihilation $plugin){
		$this->plugin = $plugin;
	}
	
	public function downloadFile(string $path, string $link) : bool{
		if(!file_put_contents($path, file_get_contents($link, false, stream_context_create(array("ssl" => array("verify_peer" => false, "verify_peer_name" => false)))))){
			//
			$this->enabled(false);
		}else{
			
			
		}
	}
	
	public function downloadPlugin(string $path = "", string $pluginName = "") : bool{
		$fileName = str_replace(".phar", "", $fileName);
		$pathInfo = pathinfo($path);
		if($pathInfo["extension"] == "phar"){
			$dir = $pathInfo["dirname"] . "/";
			$file = $pathInfo["filename"];
		}else{
			$dir = $pathInfo["dirname"] . "/";
			if($pathInfo["basename"] !== $pathInfo["filename"]){
				$dir .= $pathInfo["basename"];
			}
			$file = $pluginName;
		}
		if($pluginName == "") $pluginName = $file;
		if(!file_put_contents($dir . $file . ".phar", file_get_contents("https://poggit.pmmp.io/get/" . $pluginName, false, stream_context_create(array("ssl" => array("verify_peer" => false, "verify_peer_name" => false))))){
			return false;
		}else{
			$this->plugin->log($this->translateValue("{plugin}", $file, Annihilation::SYSTEM_LANG["plugin-download-plugin"], "notice", true);
			$this->getServer()->getPluginManager()->loadPlugin($path . $pluginName . "phar");
			$this->plugin->log($this->translateValue("{plugin}", $file, Annihilation::SYSTEM_LANG["plugin-enable-plugin"], "notice", true);
			return true;
		}
	}
	
	public function translateValue(){
	}
}