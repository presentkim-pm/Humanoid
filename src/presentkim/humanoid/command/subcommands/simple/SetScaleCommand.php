<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\PlayerAct;
use presentkim\humanoid\act\child\SetHumanoidScaleAct;
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\util\{
  Translation, Utils
};

class SetScaleCommand extends SimpleSubCommand{

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
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                $scale = Utils::toInt($args[0], null, function (int $i){
                    return $i >= 10;
                });
                if ($scale === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                    return false;
                } else {
                    PlayerAct::registerAct(new SetHumanoidScaleAct($sender, $scale));
                    return true;
                }
            } else {
                $sender->sendMessage(Plugin::$prefix . $this->usage);
                return false;
            }
        } else {

            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}