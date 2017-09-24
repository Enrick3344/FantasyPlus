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
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
// Plugin Files.
use FantasyPlus\Main;

class EventListener implements Listener{

    /** @var Main */
    private $plugin;
	
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
	}
  
  
/*                                                                        
 * ,------.                 ,--.                 ,--.  ,--.                
 * |  .--. ',--.--. ,---. ,-'  '-. ,---.  ,---.,-'  '-.`--' ,---. ,--,--,  
 * |  '--' ||  .--'| .-. |'-.  .-'| .-. :| .--''-.  .-',--.| .-. ||      \ 
 * |  | --' |  |   ' '-' '  |  |  \   --.\ `--.  |  |  |  |' '-' '|  ||  | 
 * `--'     `--'    `---'   `--'   `----' `---'  `--'  `--' `---' `--''--' 
*/
public function onExhaust(PlayerExhaustEvent $event){
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$hunger = $this->plugin->getConfig()->get("Hunger");
        if(in_array($world, $hunger)){
             $event->setCancelled(true);
	    }
	}
	
	public function onBreak(BlockBreakEvent $event){
		$prefix = $this->plugin->getConfig()->get("Prefix");
		$breakmessage = $this->plugin->getConfig()->get("Break-Message");
		$lockmessage = $this->plugin->getConfig()->get("Lock-Message");
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$break = $this->plugin->getConfig()->get("Break");
		$lock = $this->plugin->getConfig()->get("Lock");
		if(in_array($world, $lock)){
			$event->setCancelled(true);
			$player->sendMessage($this->plugin->translateColors($prefix . " " . $lockmessage));
		}elseif(in_array($world, $break)){
			if($player->hasPermission("fantasyplus.break.bypass")){
				return true;
			}else{
			$event->setCancelled();
			$player->sendMessage($this->plugin->translateColors($prefix . " " . $breakmessage));
			}
		}
	}
	
	public function onPlace(BlockPlaceEvent $event){
		$prefix = $this->plugin->getConfig()->get("Prefix");
		$placemessage = $this->plugin->getConfig()->get("Place-Message");
		$lockmessage = $this->plugin->getConfig()->get("Lock-Message");
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$place = $this->plugin->getConfig()->get("Place");
		$lock = $this->plugin->getConfig()->get("Lock");
		if(in_array($world, $lock)){
			$event->setCancelled(true);
			$player->sendMessage($this->plugin->translateColors($prefix . " " . $lockmessage));
		}elseif(in_array($world, $place)){
			if($player->hasPermission("fantasyplus.place.bypass")){
				return true;
			}else{
			$event->setCancelled();
			$player->sendMessage($this->plugin->translateColors($prefix . " " . $placemessage));
			}
		}
	}
	
	public function onDrop(PlayerDropItemEvent $event){
		$prefix = $this->plugin->getConfig()->get("Prefix");
		$message = $this->plugin->getConfig()->get("Drop-Message");
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$drop = $this->plugin->getConfig()->get("Drop");
		
		if(in_array($world, $drop)){
			if($player->hasPermission("fantasyplus.drop.bypass")){
				return true;
			}else{
			$event->setCancelled();
			$player->sendMessage($this->plugin->translateColors($prefix . " " . $message));
			}
		}
	}
	
	public function onHurt(EntityDamageEvent $event){
		if($event->getEntity() instanceof Player && $event instanceof EntityDamageByEntityEvent) {
			if($event->getDamager() instanceof Player){
				$prefix = $this->plugin->getConfig()->get("Prefix");
				$message = $this->plugin->getConfig()->get("PVP-Message");
				$pvp = $this->plugin->getConfig()->get("PVP");
				$player = $event->getDamager();
				$world = $player->getLevel()->getName();
				if(in_array($world, $pvp)){
					$event->getDamager()->sendMessage($this->plugin->translateColors($prefix . " " . $message));
					$event->setCancelled();
				}
			}
		}
	}
  
  
/*                                            
 * ,------.                                    
 * |  .---',--.--. ,---.  ,---. ,-----. ,---.  
 * |  `--, |  .--'| .-. :| .-. :`-.  / | .-. : 
 * |  |`   |  |   \   --.\   --. /  `-.\   --. 
 * `--'    `--'    `----' `----'`-----' `----' 
*/
public function onMove(PlayerMoveEvent $event) {
		$freeze =  $this->plugin->freeze->get("Frozen");
		$message = $this->plugin->getConfig()->get("Freeze-Popup-Message");
		$name = $event->getPlayer()->getName();
		$player = $event->getPlayer();
		if(in_array($name, $freeze)){
			if($player->hasPermission("fantasyplus.freeze.bypass")){
				return true;
			}else{
			$event->getPlayer()->sendPopup($this->plugin->translateColors($message));
			$event->setCancelled();
			}
		}
	}
  
  
/*                                  
 *  ,-----.,--.               ,--.   
 * '  .--./|  ,---.  ,--,--.,-'  '-. 
 * |  |    |  .-.  |' ,-.  |'-.  .-' 
 * '  '--'\|  | |  |\ '-'  |  |  |   
 *  `-----'`--' `--' `--`--'  `--'   
*/
 public function onPlayerChat(PlayerChatEvent $event) {
		$player = $event->getPlayer();
		$config = $this->plugin->getConfig()->get("Disable-Chat");
		if($config == "true"){
			if($player->hasPermission("fantasyplus.chat.bypass")){
				return true;
			}else{
			$event->setCancelled();
		}
	}elseif($config == "false"){
		return true;	
	}
}


/*                                         
 * ,--.  ,--.         ,--.                  
 * |  ,'.|  | ,---. ,-'  '-. ,---.  ,--,--. 
 * |  |' '  || .-. |'-.  .-'| .-. |' ,-.  | 
 * |  | `   |' '-' '  |  |  | '-' '\ '-'  | 
 * `--'  `--' `---'   `--'  |  |-'  `--`--' 
 *                          `--'                                              
*/ 
public function onEntityTeleport(EntityTeleportEvent $event){
		$entity = $event->getEntity();
		$location = $event->getTo();
			if($entity instanceof Player){
				foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
		  			if($location->x == $player->x && $location->y == $player->y && $location->z == $player->z){
					  $name = $player->getPlayer()->getName();
						$config = $this->plugin->getConfig()->get("NoTPA");
						   if(in_array($name, $config)){
               						 if(!$entity->getPlayer()->hasPermission("fantasyplus.notpa.bypass")){				
                						$event->setCancelled(true);
								$entity->getPlayer()->sendMessage("§l§dNotice§5>§r§c " . $entity->getPlayer()->getName() . " Doesn't Accept TP.");
							 }
						 }
					}
				}
			}
	}
}
