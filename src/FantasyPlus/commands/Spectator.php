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

class Spectator extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("spc", "Set your gamemode to Spectator", null, ["spc"]);
        $this->setPermission("fantasyplus.command.s");
        $this->plugin = $plugin;
	}
	
	public function execute(CommandSender $sender, string $label, array $args) : bool{
			 if(!($sender instanceof Player)){
                    $sender->sendMessage("§5>§c Please run this command in-game.");
                    return true;
         }
		 $player = $this->plugin->getServer()->getPlayer($sender->getName());
		 if($player->getGamemode() == 3){
			 $player->sendMessage("§5>§c You are already in spectator mode.");
		 }else{
			 $player->setGamemode(3);
			 $player->sendMessage("§5>§d You are now in Spectator Mode");
		 }
		 return true;
	}
}
