<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\command\CommandSender;

use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\command\subcommands\SetSubCommand;
use presentkim\humanoid\util\Translation;

use function presentkim\humanoid\util\toInt;

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
        foreach (SetSubCommand::getSubCommands() as $key => $value) {
            $list[] = [
              $value->getLabel(),
              $value->getUsage(),
            ];
        }

        $max = ceil(count($list) / 5);
        $page = min($max, (isset($args[0]) ? toInt($args[0], 1, function (int $i){
              return $i > 0 ? 1 : -1;
          }) : 1) - 1);
        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-humanoid-set-list@head', $page + 1, $max));
        for ($i = $page * 5; $i < ($page + 1) * 5 && $i < count($list); $i++) {
            $sender->sendMessage(Translation::translate('command-humanoid-set-list@item', ...$list[$i]));
        }
        return false;
    }
}