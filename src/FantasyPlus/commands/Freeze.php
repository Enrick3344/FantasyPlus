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

class Freeze extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("freeze", "Disable all player mouvment", null, ["freeze"]);
        $this->setPermission("fantasyplus.command.freeze");
        $this->plugin = $plugin;
	}
	
	public function execute(CommandSender $sender, string $label, array $args) : bool{
		if(isset($args[0])){
				$victim = $args[0];
				$player = $this->plugin->getServer()->getPlayer($victim);
					if($player === null) {
						$sender->sendMessage("§5>§c " . $victim . " Isnt a valid player Or is Not Online!");
						}else{
							$freeze = $this->plugin->freeze->get("Frozen");
							$name = $player->getName();
							if(in_array($name, $freeze)) {
								$sender->sendMessage("§5>§c " . $victim . " Is Already Frozen!");
							}else{
								$array = $this->plugin->freeze->get("Frozen");
								$frozen = $array;
								$frozen[] = $player->getName();
								$this->plugin->freeze->set("Frozen", $frozen);
								$this->plugin->freeze->save();
								$sender->sendMessage("§5>§d You have Successfully Froze " . $player->getName());
							}
						}
					}else{
						$sender->sendMessage("§l§dUsage§5>§r§b /freeze <player>");
					}
					return true;
				}
	}
