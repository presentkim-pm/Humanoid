<?php

namespace kim\present\humanoid\command\subcommands;

use kim\present\humanoid\command\{
	PoolCommand, SubCommand
};
use kim\present\humanoid\Humanoid as Plugin;
use pocketmine\command\CommandSender;

class ReloadSubCommand extends SubCommand{

	public function __construct(PoolCommand $owner){
		parent::__construct($owner, 'reload');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		$this->plugin->load();
		$sender->sendMessage(Plugin::$prefix . $this->translate('success'));

		return true;
	}
}