<?php

namespace kim\present\humanoid\command\subcommands\simple;

use kim\present\humanoid\act\child\SetHumanoidNameAct;
use kim\present\humanoid\act\PlayerAct;
use kim\present\humanoid\command\SimpleSubCommand;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SetNameCommand extends SimpleSubCommand{
	/**
	 * SetNameCommand constructor.
	 */
	public function __construct(){
		parent::__construct('name');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if($sender instanceof Player){
			PlayerAct::registerAct(new SetHumanoidNameAct($sender, implode(' ', $args)));
			return true;
		}else{
			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
			return false;
		}
	}
}