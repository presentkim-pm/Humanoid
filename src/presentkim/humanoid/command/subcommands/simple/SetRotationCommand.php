<?php

namespace presentkim\humanoid\command\subcommands\simple;


use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, task\PlayerTask, task\SetRotationTask, util\Translation
};
use function presentkim\humanoid\util\toInt;

class SetRotationCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('rotation');
    }

    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($args[0] === '*') {
                    PlayerTask::registerTask(new SetRotationTask($sender));
                    return true;
                } elseif (isset($args[1])) {
                    $yaw = toInt($args[0], null, function (int $i){
                        return $i >= 0;
                    });
                    $pitch = toInt($args[1], null, function (int $i){
                        return $i >= 0;
                    });
                    if ($yaw === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                        return false;
                    } elseif ($pitch === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[1]));
                        return false;
                    } else {
                        PlayerTask::registerTask(new SetRotationTask($sender, $yaw, $pitch));
                        return true;
                    }
                } else {
                    $sender->sendMessage(Plugin::$prefix . $this->usage);
                    return false;
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