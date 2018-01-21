<?php

namespace presentkim\humanoid\command\subcommands\simple;


use pocketmine\command\CommandSender;
use pocketmine\entity\Skin;
use pocketmine\Player;
use pocketmine\Server;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\task\{
  PlayerTask, HumanoidSetTask
};

class SetSkinCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('skin');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($args[0] === '*') {
                    $skin = $sender->getSkin();
                } else {
                    $player = Server::getInstance()->getPlayerExact($args[0]);
                    if ($player === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-player', $args[0]));
                        return false;
                    } else {
                        $skin = $player->getSkin();
                    }
                }
            } else {
                $skin = $sender->getSkin();
            }
            PlayerTask::registerTask(new class ($sender, $skin) extends HumanoidSetTask{

                /** @var Skin | null */
                private $skin;

                /**
                 * @param Player    $player
                 * @param Skin|null $skin
                 */
                public function __construct(Player $player, Skin $skin = null){
                    parent::__construct($player);
                    $this->skin = $skin;
                }

                /** @param PlayerClickHumanoidEvent $event */
                public function onClickHumanoid(PlayerClickHumanoidEvent $event){
                    $event->getHumanoid()->setSkin($this->skin);
                    $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-skin@success'));

                    $event->setCancelled(true);
                    $this->cancel();
                }
            });
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}