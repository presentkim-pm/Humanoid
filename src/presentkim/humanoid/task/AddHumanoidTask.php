<?php

namespace presentkim\humanoid\task;


use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class AddHumanoidTask extends PlayerTask{

    /** @var string */
    private $name;

    public function __construct(Player $player, string $name){
        parent::__construct($player);
        $this->name = $name;
    }

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
}