<?php

namespace kim\present\humanoid\command\subcommands\simple;

use kim\present\humanoid\act\child\SetHumanoidGeometryAct;
use kim\present\humanoid\act\PlayerAct;
use kim\present\humanoid\command\SimpleSubCommand;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SetGeometryCommand extends SimpleSubCommand{
	/**
	 * SetGeometryCommand constructor.
	 */
	public function __construct(){
		parent::__construct('geometry');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if($sender instanceof Player){
			if(!isset($args[0]) || $args[0] === '*'){
				$geometryName = $sender->getSkin()->getGeometryName();
			}else{
				$geometryName = implode('_', $args);
			}
			PlayerAct::registerAct(new SetHumanoidGeometryAct($sender, $geometryName));
			return true;
		}else{
			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
			return false;
		}
	}
}