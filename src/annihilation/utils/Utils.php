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
	
	public function downloadFile(string $path, string $link, string $name) : bool{
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
		if(!file_put_contents($dir . $file . ".phar", file_get_contents($base_url . $pluginName, false, stream_context_create(array("ssl" => array("verify_peer" => false, "verify_peer_name" => false)))))){
			$this->plugin->log($this->translateValue(["{plugin}", "{version}"], $file, Annihilation::SYSTEM_LANG["plugin-downloading-failed"]), "alert", true);
			return false;
		}else{
			$this->plugin->log($this->translateValue(["{plugin}", "{version}"], $file, Annihilation::SYSTEM_LANG["plugin-downloading-success"]), "info", true);
			$this->plugin->log($this->translateValue("{plugin}", $file, Annihilation::SYSTEM_LANG["plugin-enabling"]), "info", true);
			if(is_null($plugin = $this->plugin->getServer()->getPluginManager()->loadPlugin($path . $pluginName . "phar"))){
				$this->plugin->log($this->translateValue("{plugin}", $file, Annihilation::SYSTEM_LANG["plugin-enable-plugin-failed"]), "alert", true);
			}else{
				$this->plugin->log($this->translateValue("{plugin}", $plugin->getFullName(), Annihilation::SYSTEM_LANG["plugin-enable-plugin-success"]), "info", true);
			}
			return true;
		}
	}
	
	public function downloadPlugin(string $path = "", string $pluginName = "", string $base_url = "https://poggit.pmmp.io/get/") : bool{
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
		$this->plugin->log($this->translateValue(["{plugin}", "{version}"], $file, Annihilation::SYSTEM_LANG["plugin-downloading"]), "alert", true);
		if(!file_put_contents($dir . $file . ".phar", file_get_contents($base_url . $pluginName, false, stream_context_create(array("ssl" => array("verify_peer" => false, "verify_peer_name" => false)))))){
			$this->plugin->log($this->translateValue(["{plugin}", "{version}"], $file, Annihilation::SYSTEM_LANG["plugin-downloading-failed"]), "alert", true);
			return false;
		}else{
			$this->plugin->log($this->translateValue(["{plugin}", "{version}"], $file, Annihilation::SYSTEM_LANG["plugin-downloading"]), "info", true);
			$this->plugin->log($this->translateValue("{plugin}", $file, Annihilation::SYSTEM_LANG["plugin-enabling"]), "info", true);
			if(is_null($plugin = $this->plugin->getServer()->getPluginManager()->loadPlugin($path . $pluginName . ".'.phar"))){
				$this->plugin->log($this->translateValue("{plugin}", $file, Annihilation::SYSTEM_LANG["plugin-enable-plugin-failed"]), "alert", true);
			}else{
				$this->plugin->log($this->translateValue("{plugin}", $plugin->getFullName(), Annihilation::SYSTEM_LANG["plugin-enable-plugin-success"]), "info", true);
			}
			return true;
		}
	}
	
	public function download(string $path = "", string $pluginName = "", string $base_url = "//Todo") : bool{
		$fileName = str_replace(".phar", "", $fileName);
		$pathInfo = pathinfo($path);
		$extension = $pathInfo["extension"];
		if($extension == "phar"){
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
		if(!file_put_contents($dir . $file . $extension, file_get_contents($base_url . $pluginName, false, stream_context_create(array("ssl" => array("verify_peer" => false, "verify_peer_name" => false)))))) return false; else return true;
	}
	
	/**
	*/
	/*public function translate($from, $to, string $string){
	}*/
	
	public function translateValue($from, $to, string $string, int $count){
		return str_replace($from, $to, $string);
	}
	
	public function dec2Rgb($decStr, $returnAsString = false, $seperator = ",") {
		$hexStr = preg_replace("/[^0123456789abcdef]/", "", strtolower(dechex($decStr)));
		//Normalize a proper hex string with length 6
		if(strlen($hexStr) == 3) $hexStr = preg_replace("/(.)(.)(.)/", "\1\1\2\2\3\3", $hexStr);
		//Converts hex to rgb
		if(preg_match("/^[0123456789abcdef]{6}$/",$hexStr)){
			$rgbResult=array();
			#2 characters will correspond to each colour
			foreach(array("red","green","blue") as $str_pos =>$colour_index){
				$rgbResult[$colour_index]=hexdec(substr($hexStr,2*$str_pos,2));
				#return array o string depending on second paramenter
				return $returnAsString ? implode($seperator, $rgbResult) : $rgbResult;
			}
		}
		return false; //Invalid hex colour code
	}
}