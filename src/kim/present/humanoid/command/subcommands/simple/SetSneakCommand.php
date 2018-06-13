<?php

namespace kim\presenthumanoid\command\subcommands\simple;

use kim\presenthumanoid\act\child\ToggleHumanoidSneakAct;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\command\SimpleSubCommand;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SetSneakCommand extends SimpleSubCommand{

	public function __construct(){
		parent::__construct('sneak');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if($sender instanceof Player){
			PlayerAct::registerAct(new ToggleHumanoidSneakAct($sender));
			return true;
		}else{
			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
			return false;
		}
	}
}