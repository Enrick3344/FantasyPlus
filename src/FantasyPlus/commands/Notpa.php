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

namespace FantasyPlus\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
//Plugins Files.
use FantasyPlus\Main;

class Notpa extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("notpa", "Toggle tp On or Off", null, ["notpa"]);
        $this->setPermission("fantasyplus.command.notpa");
        $this->plugin = $plugin;
	}
  
  public function execute(CommandSender $sender, string $label, array $args) : bool{
	  if(!$sender instanceof Player){
			$sender->sendMessage("§5>§c Please run this command in-game.");
			return false;
		}
      if(!isset($args[0])){
          switch($args[0]){
            case "on":{
              $name = $sender->getPlayer()->getName();
              $notpa = $this->plugin->getConfig()->get("NoTPA");
                if(in_array($name, $notpa)){
         			    $sender->sendMessage("§l§dNotice§5>§r§c NoTpa Is Already Enabled For You!");
         			    break;
         		    }
								  $array = $this->plugin->getConfig()->get("NoTPA");
								  $config = $array;
								  $config[] = $sender->getPlayer()->getName();
								  $this->plugin->getConfig()->set("NoTPA", $config);
								  $this->plugin->getConfig()->save();
                  $sender->sendMessage("§l§5>§r§b You have Successfully Enabled NoTpa! Players Cannot Teleport To You!");
             }
			  break;
             case "off":{
              $name = $sender->getPlayer()->getName();
              $notpa = $this->plugin->getConfig()->get("NoTPA");
                if(in_array($name, $notpa)){
                  $array = $this->plugin->getConfig()->get("NoTPA");
								  $rm = $sender->getPlayer()->getName();
								  $config = [];
								    foreach($array as $value) {
									    if($value != $rm) {
										    $config[] = $value;
									    }
								    }
								$this->plugin->getConfig()->set("NoTPA", $config);
								$this->plugin->getConfig()->save();
                }else{
                  $sender->sendMessage("§l§dNotice§5>§r§c NoTpa Is Already Disabled For You!");
                }
             }
              
          }
        }else{
          $sender->sendMessage("§l§dUsage§5>§r§b /notpa <on|off>");
					return false;
        }
      }
}
