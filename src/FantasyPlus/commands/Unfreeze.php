<?php 

namespace FantasyPlus\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
//Plugins Files.
use FantasyPlus\Main;

class Unfreeze extends Command{
	
	/** @var Main */
    private $plugin;
    /**
     * @param Main $plugin
    */
    public function __construct(Main $plugin){
        parent::__construct("unfreeze", "reenable all player mouvment", null, ["unfreeze"]);
        $this->setPermission("fantasyplus.command.unfreeze");
        $this->plugin = $plugin;
	}
	
	public function execute(CommandSender $sender, string $label, array $args) : bool{
		if(isset($args[0])) {
			$victim = $args[0];
			$player = $this->plugin->getServer()->getPlayer($victim);
				if($player === null) {
						$sender->sendMessage("§5>§c " . $victim . " Isnt a valid player Or is Not Online!");
						}else{
							$freeze = $this->plugin->freeze->get("Frozen");
							$name = $player->getName();
								if(in_array($name, $freeze)){
									$array = $this->plugin->freeze->get("Frozen");
									$rm = $player->getName();
									$frozen = [];
									foreach($array as $value){
										if($value != $rm) {
										$config[] = $value;
										}
									}
									$this->plugin->freeze->set("Frozen", $frozen);
									$this->plugin->freeze->save();
									$sender->sendMessage("§5>§d You Have Sucessfully Unfroze " . $victim);
								}else{
									$sender->sendMessage("§5>§c ".$victim." Isn't Frozen!");
								}
					
						}
					}else{
						$sender->sendMessage("§l§dUsage§5>§r§b /unfreeze <player>");
					}
					return true;
				}
}