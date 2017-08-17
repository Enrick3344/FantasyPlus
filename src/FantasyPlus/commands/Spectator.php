<?php 

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
	
	public function execute(CommandSender $sender, $label, array $args){
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