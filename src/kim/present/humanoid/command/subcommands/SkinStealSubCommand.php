<?php

namespace kim\present\humanoid\command\subcommands;

use kim\present\humanoid\act\child\StealHumanoidSkinAct;
use kim\present\humanoid\act\PlayerAct;
use kim\present\humanoid\command\{
	PoolCommand, SubCommand
};
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SkinStealSubCommand extends SubCommand{
	/**
	 * SkinStealSubCommand constructor.
	 *
	 * @param PoolCommand $owner
	 */
	public function __construct(PoolCommand $owner){
		parent::__construct($owner, 'skinsteal');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if($sender instanceof Player){
			PlayerAct::registerAct(new StealHumanoidSkinAct($sender));
			$sender->sendMessage(Plugin::$prefix . $this->translate('success'));
		}else{
			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
		}
		return true;
	}
}