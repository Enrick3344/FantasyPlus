<?php

namespace FantasyPlus;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\level\Level;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PLayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

//plugin Files.
use FantasyPlus\commands\Adventure;
use FantasyPlus\commands\Creative;
use FantasyPlus\commands\Survival;
use FantasyPlus\commands\TimeStuck;
use FantasyPlus\commands\FantasyPlus;
use FantasyPlus\commands\Protection;
use FantasyPlus\commands\Freeze;
use FantasyPlus\commands\Unfreeze;

class Main extends PluginBase implements Listener{
	
	public $frozens = [];
	
	public function onEnable(){
		$this->loadCommand();
		$this->loadConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->notice(TextFormat::AQUA . "FantasyPlus Enabled!");
	}
	
	public function onDisable(){
		$this->getLogger()->notice(TextFormat::AQUA . "FantasyPlus disabled!");
	}
	
	public function loadCommand(){
		$commands = [
			"timestuck" => new TimeStuck($this),
			"s" => new Survival($this),
			"c" => new Creative($this),
			"a" => new Adventure($this),
			"fantasyplus" => new FantasyPlus($this),
			"protection" => new Protection($this),
			"freeze" => new Freeze($this),
			"unfreeze" => new Unfreeze($this)
		];
		foreach($commands as $name => $class){
			$this->getServer()->getCommandMap()->register($name, $class);
		}
	}
	
	public function loadConfig(){
		if(!is_dir($this->getDataFolder())) mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder()."config.yml", Config::YAML, array(
			'Prefix' => "§7[§dFantasyProtection§7]",
			'Hunger' => array(
		           'world'),
			'Break' => array(
		          'world'),
			'Break-Message' => "§cYou are not aloud to break blocks here!",
			'Place' => array(
		          'world'),
			'Place-Message' => "§cYou are not aloud to place blocks here!",
			'Drop' => array(
			     'world'),
			'Drop-Message' => "§cYou are not aloud to drop items or blocks here!"
			));
		$this->config->save();
		$this->freeze = new Config($this->getDataFolder()."freeze.yml", Config::YAML, array(
			'Frozen' => []));
		$this->freeze->save();
	}
	
	
	//Protection Command.
	public function onExhaust(PlayerExhaustEvent $event){
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$hunger = $this->getConfig()->get("Hunger");
        if(in_array($world, $hunger)){
             $event->setCancelled(true);
	    }
	}
	
	public function onBreak(BlockBreakEvent $event){
		$prefix = $this->getConfig()->get("Prefix");
		$message = $this->getConfig()->get("Break-Message");
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$break = $this->getConfig()->get("Break");
		
		if(in_array($world, $break)){
			if($player->hasPermission("fantasyplus.break.bypass")){
				return true;
			}else{
			$event->setCancelled();
			$player->sendMessage($prefix . " " . $message);
			}
		}
	}
	
	public function onPlace(BlockPlaceEvent $event){
		$prefix = $this->getConfig()->get("Prefix");
		$message = $this->getConfig()->get("Place-Message");
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$place = $this->getConfig()->get("Place");
		
		if(in_array($world, $place)){
			if($player->hasPermission("fantasyplus.place.bypass")){
				return true;
			}else{
			$event->setCancelled();
			$player->sendMessage($prefix . " " . $message);
			}
		}
	}
	
	public function onDrop(PlayerDropItemEvent $event){
		$prefix = $this->getConfig()->get("Prefix");
		$message = $this->getConfig()->get("Drop-Message");
		$player = $event->getPlayer();
		$world = $player->getLevel()->getName();
		$drop = $this->getConfig()->get("Drop");
		
		if(in_array($world, $drop)){
			if($player->hasPermission("fantasyplus.drop.bypass")){
				return true;
			}else{
			$event->setCancelled();
			$player->sendMessage($prefix . " " . $message);
			}
		}
	}
	
	
	//Freeze Command.
	public function onMove(PlayerMoveEvent $event) {
		$freeze =  $this->freeze->get("Frozen");
		$name = $event->getPlayer()->getName();
		$player = $event->getPlayer();
		if(in_array($name, $freeze)){
			if($player->hasPermission("fantasyplus.freeze.bypass")){
				return true;
			}else{
			$event->getPlayer()->sendPopup("§l§5>§r§b You Are Frozen!");
			$event->setCancelled();
			}
		}
	}
}