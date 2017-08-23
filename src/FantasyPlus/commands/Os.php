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
//Plugins Files.
use FantasyPlus\Main;

class Os extends Command {
    /** @var Main */
    private $plugin;
	
    /**
     * @param Main $plugin
    */
   public function __construct(Main $plugin){
        parent::__construct("os", "Displays OS information", null, ["os"]);
        $this->setPermission("fantasyplus.command.os");
        $this->plugin = $plugin;
   }
   
	/**
	 * execute()
	 *
	 * @param CommandSender $sender
	 * @param string $label
	 * @param array $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $label, array $args): bool {
		  $operatesys = php_uname("s");
	  	  	$verinfo = php_uname("v");
	  	  	$releasen = php_uname("r");
	  	  	$architect = php_uname("m");
	  	  	$sender->sendMessage("§l§5>§d-------§r§bServer OS Info§l§d-------§5<");
	  	  	$sender->sendMessage("§l§5>§r§b Server OS: §f" . $operatesys);
	  	  	$sender->sendMessage("§l§5>§r§b Kernel Build Date: §f" . $verinfo);
	  	        $sender->sendMessage("§l§5>§r§b Kernel Version: §f" . $releasen);
	  	        $sender->sendMessage("§l§5>§r§b Server Architecture: §f" . $architect);
	  	        $sender->sendMessage("§l§5>§d---------------------------§5<");
		  	$log = fopen("FantasyPlus_OSRequestLog.txt","a+");
	  	        fwrite($log, "[" .  date("Y/m/d l h:i:s a") . "] " . $sender->getName() . " requested our server info.\n");
	  	        fclose($log);
	  	   return true;
		}
	}
