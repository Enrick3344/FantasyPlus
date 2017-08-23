<?php

namespace eofla\osserver;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\{Command, CommandSender};
use FantasyPlus\Main;

class Os extends Command {
	
	/**
	 * execute()
	 *
	 * @param CommandSender $sender
	 * @param string $label
	 * @param array $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $label, array $args): bool {
		  $operatesys = php_uname("s");
	  	  	$verinfo = php_uname("v");
	  	  	$releasen = php_uname("r");
	  	  	$architect = php_uname("m");
	  	  	$sender->sendMessage(TextFormat::GOLD . "------- Server OS Info -------");
	  	  	$sender->sendMessage(TextFormat::GOLD . "-> Server OS: " . TextFormat::AQUA .  $operatesys);
	  	  	$sender->sendMessage(TextFormat::GOLD . "-> Kernel Build Date: " . TextFormat::AQUA . $verinfo);
	  	        $sender->sendMessage(TextFormat::GOLD . "-> Kernel Version: " . TextFormat::AQUA . $releasen);
	  	        $sender->sendMessage(TextFormat::GOLD . "-> Server Architecture: " . TextFormat::AQUA . $architect);
	  	        $sender->sendMessage(TextFormat::GOLD . "----------------------------");
		  	$log = fopen("Eofla-OSRequestLog.txt","a+");
	  	        fwrite($log, "[" .  date("Y/m/d l h:i:s a") . "] " . $sender->getName() . " requested our server info.\n");
	  	        fclose($log);
	  	   return true;
		}
	}
