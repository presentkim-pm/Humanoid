<?php

namespace kim\present\humanoid\command\subcommands\simple;

use kim\present\humanoid\act\child\SetHumanoidRotationAct;
use kim\present\humanoid\act\PlayerAct;
use kim\present\humanoid\command\SimpleSubCommand;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;

class SetRotationCommand extends SimpleSubCommand{

	public function __construct(){
		parent::__construct('rotation');
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
				$yaw = $sender->yaw;
				$pitch = $sender->pitch;
			}elseif(isset($args[1])){
				$yaw = is_numeric($args[0]) ? (float) $args[0] : null;
				$pitch = is_numeric($args[1]) ? (float) $args[1] : null;
				if($yaw === null){
					$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
					return false;
				}elseif($pitch === null){
					$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[1]));
					return false;
				}
			}else{
				$sender->sendMessage(Server::getInstance()->getLanguage()->translateString("commands.generic.usage", [$this->usage]));
				return false;
			}
			PlayerAct::registerAct(new SetHumanoidRotationAct($sender, $yaw, $pitch));
			return true;
		}else{
			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
			return false;
		}
	}
}