<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\nbt\tag\CompoundTag;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct, InteractAct
};
use presentkim\humanoid\command\{
  SubCommand, PoolCommand,
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class CopySubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'copy');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new  class ($sender) extends PlayerAct implements ClickHumanoidAct{

                /** @param PlayerClickHumanoidEvent $event */
                public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
                    $this->cancel();
                    PlayerAct::registerAct(new class ($this->player, clone $event->getHumanoid()->namedtag) extends PlayerAct implements InteractAct{

                        /** @var CompoundTag */
                        private $nbt;

                        /**
                         * @param Player      $player
                         * @param CompoundTag $nbt
                         */
                        public function __construct(Player $player, CompoundTag $nbt){
                            parent::__construct($player);
                            $this->nbt = $nbt;
                        }

                        /** @param PlayerInteractEvent $event */
                        public function onInteract(PlayerInteractEvent $event) : void{
                            $pos = $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR ? $this->player->asPosition() : $pos = $event->getBlock();
                            $this->nbt->setTag(new ListTag("Pos", [
                              new DoubleTag("", $pos->x),
                              new DoubleTag("", $pos->y),
                              new DoubleTag("", $pos->z),
                            ]));

                            $entity = Entity::createEntity('Humanoid', $pos->level, $this->nbt);
                            $entity->spawnToAll();

                            $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-copy@success-paste'));

                            $event->setCancelled(true);
                            $this->cancel();
                        }
                    });

                    $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-copy@success-copy'));

                    $event->setCancelled(true);
                }
            });
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}