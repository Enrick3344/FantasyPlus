<?php 

namespace FantasyPlus\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
//Plugins Files.
use FantasyPlus\Main;

class Chat extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("chat", "Toggle Chat On or Off", null, ["chat"]);
        $this->setPermission("fantasyplus.command.chat");
        $this->plugin = $plugin;
	}
  
	public function execute(CommandSender $sender, $label, array $args){
		if(isset($args[0])){
			switch(strtolower($args[0])){
        case "on":{
          $this->plugin->config->get("Disabled-Chat");
          $this->plugin->config->set("Disaled-Chat", false);
          $this->plugin->config->save();
          $sender->sendMessage("§l§5>§r§d Chat Has Been Enabled!");
          $this->plugin->getLogger()->notice(TextFormat::LIGHT_PURPLE . "Chat Has Been Enabled!");
        }
        break;
        case "off":{
          $this->plugin->config->get("Disabled-Chat");
          $this->plugin->config->set("Disaled-Chat", true);
          $this->plugin->config->save();
          $sender->sendMessage("§l§5>§r§d Chat Has Been Disabled!");
          $this->plugin->getLogger()->notice(TextFormat::LIGHT_PURPLE . "Chat Has Been Disabled!");
        }
        break;
        }
        }else{
          $sender->sendMessage("§l§dUsage§5>§r§b /chat <on|off>");
          }
     return true;
   }
}
          
