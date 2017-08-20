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

class FantasyPlus extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("fantasyplus", "shows info or help of fantasyplus", null, ["fplus"]);
        $this->setPermission("fantasyplus.command.fantasyplus");
        $this->plugin = $plugin;
	}
	
	private function sendHelp(CommandSender $sender){
        $commands = [
            "/fantasyplus <help/info>" => "Shows the help and info of this plugin",
	    "/freeze <player>" => "Freezes a player mouvement",
	    "/unfreeze <player>" => "Unfreezes the player mouvements",
	    "/protect <enable|disable> <break|place|hunger|drop|pvp>" => "Protection Command. Disable is to set the flag to off so break to off. etcc..",
	    "/c" => "Sets yourself in Creative mode",
            "/s" => "Sets yourself in Survival mode",
	    "/spc" => "Sets yourself in Spectator mode",
	    "/chat <on|off>" => "Set chat to on or off!",
	    "/timestuck <level> <day|night>" => "stucks the time to on or off till server reboot."
        ];
        $sender->sendMessage("§5-§d=§bFantasyHelp Commands§d=§5-");
        foreach($commands as $cmd => $description){
            $sender->sendMessage("§5>§d $cmd §f:§b $description");
        }
    }
	
	private function sendInfo(CommandSender $sender){
        $informations = [
            "Author:" => "Enrick3344",
			"Version:" => "0.1",
			"Github:" => "https://github.com/Enrick3344/FantasyPlus"
        ];
        $sender->sendMessage("§5-§d=§bFantasyHelp v0.1§d=§5-");
        foreach($informations as $info => $description){
            $sender->sendMessage("§5>§d $info §b $description");
        }
    }	
	
	public function execute(CommandSender $sender, string $label, array $args) : bool{
		if(isset($args[0])){
			switch(strtolower($args[0])){
				case "help":
					$this->sendHelp($sender);
					break;
				case "info":
					$this->sendInfo($sender);
					break;
			}
		}else{
			$this->sendHelp($sender);
			return false;
		}
		return true;
	}
}
