<?php

namespace kim\presenthumanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\act\child\ToggleHumanoidSneakAct;
use kim\presenthumanoid\command\SimpleSubCommand;
use kim\presenthumanoid\util\Translation;

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
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new ToggleHumanoidSneakAct($sender));
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}