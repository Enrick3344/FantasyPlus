<?php 

namespace FantasyPlus\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
//Plugins Files.
use FantasyPlus\Main;

class Survival extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("s", "Set your gamemode to Survival", null, ["s"]);
        $this->setPermission("fantasyplus.command.s");
        $this->plugin = $plugin;
	}
	
	public function execute(CommandSender $sender, string $label, array $args) : bool{
			 if(!($sender instanceof Player)){
                    $sender->sendMessage("§5>§c Please run this command in-game.");
                    return true;
         }
		 $player = $this->plugin->getServer()->getPlayer($sender->getName());
		 if($player->getGamemode() == 0){
			 $player->sendMessage("§5>§c You are already in survival mode.");
		 }else{
			 $player->setGamemode(0);
			 $player->sendMessage("§5>§d You are now in survival Mode");
		 }
		 return true;
	}
}
	