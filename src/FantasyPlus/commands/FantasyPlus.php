<?php 

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
            "/fantasyplus <help/info>" => "Shows the help and info of this plugin"
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