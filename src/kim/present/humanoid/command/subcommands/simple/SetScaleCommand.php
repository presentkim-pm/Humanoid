<?php

namespace kim\present\humanoid\command\subcommands\simple;

use kim\present\humanoid\act\child\SetHumanoidScaleAct;
use kim\present\humanoid\act\PlayerAct;
use kim\present\humanoid\command\SimpleSubCommand;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\{
	Translation, Utils
};
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;

class SetScaleCommand extends SimpleSubCommand{
	/**
	 * SetScaleCommand constructor.
	 */
	public function __construct(){
		parent::__construct('scale');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		if($sender instanceof Player){
			if(isset($args[0])){
				$scale = Utils::toInt($args[0], null, function(int $i){
					return $i >= 10;
				});
				if($scale === null){
					$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
					return false;
				}else{
					PlayerAct::registerAct(new SetHumanoidScaleAct($sender, $scale));
					return true;
				}
			}else{
				$sender->sendMessage(Server::getInstance()->getLanguage()->translateString("commands.generic.usage", [$this->usage]));
				return false;
			}
		}else{

			$sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
			return false;
		}
	}
}