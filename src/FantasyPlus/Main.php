<?php

/*
 * 
 *  _____           _                  ____  _           
 * |  ___|_ _ _ __ | |_ __ _ ___ _   _|  _ \| |_   _ ___ 
 * | |_ / _` | '_ \| __/ _` / __| | | | |_) | | | | / __|
 * |  _| (_| | | | | || (_| \__ \ |_| |  __/| | |_| \__ \
 * |_|  \__,_|_| |_|\__\__,_|___/\__, |_|   |_|\__,_|___/
 * 				 |___/    
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 *
 * @author Enrick Fortier
 * 
 * Github: https://github.com/Enrick3344
 * Version: v0.1
 *
*/ 

namespace FantasyPlus;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\level\Level;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PLayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreProcessEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

//plugin Files.
use FantasyPlus\commands\Chat;
use FantasyPlus\commands\Creative;
use FantasyPlus\commands\Notpa;
use FantasyPlus\commands\Spectator;
use FantasyPlus\commands\Survival;
use FantasyPlus\commands\TimeStuck;
use FantasyPlus\commands\FantasyPlus;
use FantasyPlus\commands\Protection;
use FantasyPlus\commands\Freeze;
use FantasyPlus\commands\Unfreeze;
use FantasyPlus\commands\Os;

class Main extends PluginBase implements Listener{
	
	public $frozens = [];
	
	public function onEnable(){
		$this->loadCommand();
		$this->loadConfig();
		if(!file_exists($this->getDataFolder() . "config.yml")){
     			 @mkdir($this->getDataFolder());
     			 file_put_contents($this->getDataFolder()."config.yml", $this->getResource("config.yml"));
   		 }
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$this->getLogger()->notice(TextFormat::AQUA . "FantasyPlus Enabled!");
	}
	
	public function onDisable(){
		$this->getLogger()->notice(TextFormat::AQUA . "FantasyPlus disabled!");
	}
	
	public function loadCommand(){
		$commands = [
			"chat" => new Chat($this),
			"timestuck" => new TimeStuck($this),
			"notpa" => new Notpa($this),
			"s" => new Survival($this),
			"c" => new Creative($this),
			"spc" => new Spectator($this),
			"fantasyplus" => new FantasyPlus($this),
			"protection" => new Protection($this),
			"freeze" => new Freeze($this),
			"unfreeze" => new Unfreeze($this),
			"os" => new Os($this)
		];
		foreach($commands as $name => $class){
			$this->getServer()->getCommandMap()->register($name, $class);
		}
	}
	
	public function loadConfig(){
		$this->freeze = new Config($this->getDataFolder()."freeze.yml", Config::YAML, array(
			'Frozen' => []));
		$this->freeze->save();
	}
	
	public function translateColors($string){
		$msg = str_replace("&1",TextFormat::DARK_BLUE,$string);
		$msg = str_replace("&2",TextFormat::DARK_GREEN,$msg);
		$msg = str_replace("&3",TextFormat::DARK_AQUA,$msg);
		$msg = str_replace("&4",TextFormat::DARK_RED,$msg);
		$msg = str_replace("&5",TextFormat::DARK_PURPLE,$msg);
		$msg = str_replace("&6",TextFormat::GOLD,$msg);
		$msg = str_replace("&7",TextFormat::GRAY,$msg);
		$msg = str_replace("&8",TextFormat::DARK_GRAY,$msg);
		$msg = str_replace("&9",TextFormat::BLUE,$msg);
		$msg = str_replace("&0",TextFormat::BLACK,$msg);
		$msg = str_replace("&a",TextFormat::GREEN,$msg);
		$msg = str_replace("&b",TextFormat::AQUA,$msg);
		$msg = str_replace("&c",TextFormat::RED,$msg);
		$msg = str_replace("&d",TextFormat::LIGHT_PURPLE,$msg);
		$msg = str_replace("&e",TextFormat::YELLOW,$msg);
		$msg = str_replace("&f",TextFormat::WHITE,$msg);
		$msg = str_replace("&o",TextFormat::ITALIC,$msg);
		$msg = str_replace("&l",TextFormat::BOLD,$msg);
		$msg = str_replace("&r",TextFormat::RESET,$msg);
		return $msg;
	}			 
}
