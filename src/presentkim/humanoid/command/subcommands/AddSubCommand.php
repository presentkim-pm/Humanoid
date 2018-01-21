<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use presentkim\humanoid\command\{
  SubCommand, PoolCommand,
};
use presentkim\humanoid\{
  HumanoidMain as Plugin, util\Translation
};
use presentkim\humanoid\task\{
  PlayerTask
};

class AddSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'add');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            PlayerTask::registerTask(new  class ($sender, isset($args[0]) ? implode(' ', $args) : $sender->getNameTag()) extends PlayerTask{

                /** @var string */
                private $name;

                /**
                 * @param Player $player
                 * @param string $name
                 */
                public function __construct(Player $player, string $name){
                    parent::__construct($player);
                    $this->name = $name;
                }

                /** @param PlayerInteractEvent $event */
                public function onInteract(PlayerInteractEvent $event){
                    if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
                        $nbt = Entity::createBaseNBT($this->player, null, $this->player->yaw, $this->player->pitch);
                    } else {
                        $nbt = Entity::createBaseNBT($event->getBlock()->add(0.5, 1, 0.5));
                        $nbt->setTag($this->player->getInventory()->getItemInHand()->nbtSerialize(-1, 'HeldItem'));
                    }
                    $skin = $this->player->getSkin();
                    $nbt->setString('SkinData', $skin->getSkinData());
                    $nbt->setString('GeometryName', $skin->getGeometryName());
                    $nbt->setString('CustomName', $this->name);

                    $entity = Entity::createEntity('Humanoid', $this->player->level, $nbt);
                    $entity->spawnToAll();

                    $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-add@success'));

                    $event->setCancelled(true);
                    $this->cancel();
                }
            });
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}