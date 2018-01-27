<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;

use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

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
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($args[0] === '*') {
                    $yaw = $sender->yaw;
                    $pitch = $sender->pitch;
                } elseif (isset($args[1])) {
                    $yaw = is_numeric($args[0]) ? (float) $args[0] : null;
                    $pitch = is_numeric($args[1]) ? (float) $args[1] : null;
                    if ($yaw === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                        return false;
                    } elseif ($pitch === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[1]));
                        return false;
                    }
                } else {
                    $sender->sendMessage(Plugin::$prefix . $this->usage);
                    return false;
                }
                PlayerAct::registerAct(new  class($sender, $yaw, $pitch) extends PlayerAct implements ClickHumanoidAct{

                    /** @var int | null */
                    private $yaw;

                    /** @var int | null */
                    private $pitch;

                    /**
                     * @param Player   $player
                     * @param int|null $yaw
                     * @param int|null $pitch
                     */
                    public function __construct(Player $player, ?int $yaw = null, ?int $pitch = null){
                        parent::__construct($player);
                        $this->yaw = $yaw;
                        $this->pitch = $pitch;
                    }

                    /** @param PlayerClickHumanoidEvent $event */
                    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
                        $this->yaw = $this->yaw ?? $this->player->yaw;
                        $this->pitch = $this->pitch ?? $this->player->pitch;
                        $event->getHumanoid()->setRotation($this->yaw, $this->pitch);
                        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-rotation@success', $this->yaw, $this->pitch));

                        $event->setCancelled(true);
                        $this->cancel();
                    }
                });
                return true;
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