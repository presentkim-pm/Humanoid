<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\entity\Skin;

use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

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
    public function onCommand(CommandSender $sender, array $args) : bool{
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
            PlayerAct::registerAct(new class ($sender, $skin) extends PlayerAct implements ClickHumanoidAct{

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
                public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
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