<?php

namespace kim\presenthumanoid\command\subcommands\simple;

use kim\presenthumanoid\act\child\SetHumanoidNameAct;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\command\SimpleSubCommand;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SetNameCommand extends SimpleSubCommand{

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