<?php

namespace kim\present\humanoid\command\subcommands;

use kim\present\humanoid\act\PlayerAct;
use kim\present\humanoid\command\{
	PoolCommand, SubCommand
};
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class CancelSubCommand extends SubCommand{

	public function __construct(PoolCommand $owner){
		parent::__construct($owner, 'cancel');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if($sender instanceof Player){
			$task = PlayerAct::getAct($sender);
			if($task instanceof PlayerAct){
				$task->cancel();
				$sender->sendMessage(Plugin::$prefix . $this->translate('success'));
			}else{
				$sender->sendMessage(Plugin::$prefix . $this->translate('failure'));
			}
		}else{
			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
		}
		return true;
	}
}