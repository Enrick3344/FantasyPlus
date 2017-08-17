<?php 

namespace FantasyPlus\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
//Plugins Files.
use FantasyPlus\Main;

class TimeStuck extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("timestuck", "stuck time on certain level", null, ["timestuck"]);
        $this->setPermission("fantasyplus.command.timestuck");
        $this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $label, array $args) : bool{
        if(isset($args[0])){
            if(isset($args[1]) and $args[1] === "day"){
				if(!$this->plugin->getServer()->isLevelGenerated($args[0])){
                	  	    	    $sender->sendMessage("§5>§c Failed to set §4".$args[0]."§c because it is not a level or is not generated yet");
                	  	    	    
                	  	    	}
                	  	    	
		                    if(!$this->plugin->getServer()->isLevelLoaded($args[0])){
		                    	  $sender->sendMessage("§5>§c Level §4".$args[0]."§c Is not loaded yet! Loading...");
		                    	  $this->plugin->getServer()->loadLevel($args[0]);
		                    	  if(!$this->plugin->getServer()->loadLevel($args[0])){
		                    	  	    $sender->sendMessage("§5>§c Level §4".$args[0]."§c Could not be loaded!");
		                    	  	    
		                    	  	}
		                    	  
		                    }
                        if($this->plugin->getServer()->isLevelGenerated($args[0]) and $this->plugin->getServer()->isLevelLoaded($args[0])){
                	  	        $sender->sendMessage("§5>§b Setting Level §d".$args[0]."§b to Day!");
                	  	        $tickday = 0;
                	  	        $method = $this->plugin->getServer()->getLevelByName($args[0])->setTime($tickday);
                	  	        $method2 = $this->plugin->getServer()->getLevelByName($args[0])->stopTime();
            	  	            $sender->sendMessage("§5>§b You've stuck the time on Day on Level ".$args[0]);

                	  	    }
                	  	    
                	  } elseif(isset($args[1]) and $args[1] === "night"){
                	  	    if(!$this->plugin->getServer()->isLevelGenerated($args[0])){
                	  	    	    $sender->sendMessage("§5>§c Failed to set §4".$args[0]."§c because it is not a level or is not generated yet");
                	  	    	    
                	  	    	}
                	  	    	
		                    if(!$this->plugin->getServer()->isLevelLoaded($args[0])){
		                    	  $sender->sendMessage("§5>§c Level §4".$args[0]."§c Is not loaded yet! Loading...");
		                    	  $this->plugin->getServer()->loadLevel($args[0]);
		                    	  if(!$this->plugin->getServer()->loadLevel($args[0])){
		                    	  	    $sender->sendMessage("§5>§c Level §4".$args[0]."§c Could not be loaded!");
		                    	  	    
		                    	  	}
		                    	  
		                    }
                        if($this->plugin->getServer()->isLevelGenerated($args[0]) and $this->plugin->getServer()->isLevelLoaded($args[0])){
                	  	        $sender->sendMessage("§5>§b Setting Level §d".$args[0]."§b to Night!");
                	  	        $ticknight = 14000;
                	  	        $this->plugin->getServer()->getLevelByName($args[0])->setTime($ticknight);
                	  	        $this->plugin->getServer()->getLevelByName($args[0])->stopTime();
                	  	        $sender->sendMessage("§5>§b You've stuck the time on Night on Level ".$args[0]);
                	  	        
                	  	    }
                	  	    
                	  	} else {
                	  		
                	  		  $sender->sendMessage(TextFormat::AQUA . "Usage: /timestuck <level> <day|night>");
                	  		  
                	  	}
                	  	
                } else {
                	
                	  $sender->sendMessage(TextFormat::AQUA . "Usage: /timestuck <level> <day|night>");
                	  return false;
                }
				return true;
                
            }
}