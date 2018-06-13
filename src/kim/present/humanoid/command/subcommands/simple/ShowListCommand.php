<?php

namespace kim\present\humanoid\command\subcommands\simple;

use kim\present\humanoid\command\SimpleSubCommand;
use kim\present\humanoid\command\subcommands\SetSubCommand;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\{
	Translation, Utils
};
use pocketmine\command\CommandSender;

class ShowListCommand extends SimpleSubCommand{

	public function __construct(){
		parent::__construct('list');
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, array $args) : bool{
		$list = [];
		foreach(SetSubCommand::getSubCommands() as $key => $value){
			$list[] = [
				$value->getLabel(),
				$value->getUsage(),
			];
		}

		$max = ceil(count($list) / 5);
		$page = min($max, (isset($args[0]) ? Utils::toInt($args[0], 1, function(int $i){
							return $i > 0 ? 1 : -1;
						}) : 1) - 1);
		$sender->sendMessage(Plugin::$prefix . Translation::translate('command-humanoid-set-list@head', $page + 1, $max));
		for($i = $page * 5; $i < ($page + 1) * 5 && $i < count($list); $i++){
			$sender->sendMessage(Translation::translate('command-humanoid-set-list@item', ...$list[$i]));
		}
		return false;
	}
}