<?php

namespace blugin\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\PlayerAct;
use blugin\humanoid\act\child\SetHumanoidGeometryAct;
use blugin\humanoid\command\SimpleSubCommand;
use blugin\humanoid\util\Translation;

class SetGeometryCommand extends SimpleSubCommand{

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
        if ($sender instanceof Player) {
            if (!isset($args[0]) || $args[0] === '*') {
                $geometryName = $sender->getSkin()->getGeometryName();
            } else {
                $geometryName = implode('_', $args);
            }
            PlayerAct::registerAct(new SetHumanoidGeometryAct($sender, $geometryName));
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}