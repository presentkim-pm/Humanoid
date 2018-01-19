<?php

namespace presentkim\humanoid\listener;

use pocketmine\event\{
  Listener, server\DataPacketReceiveEvent
};
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\Server;
use presentkim\humanoid\entity\Humanoid;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param DataPacketReceiveEvent $event */
    public function onDataPacketReceiveEvent(DataPacketReceiveEvent $event){
        $pk = $event->getPacket();
        if ($pk instanceof InventoryTransactionPacket) {
            if ($pk->transactionType === InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY) {
                $player = $event->getPlayer();
                $target = $player->level->getEntity($pk->trData->entityRuntimeId);
                if ($target instanceof Humanoid) {
                    $event->setCancelled(true);
                    Server::getInstance()->getPluginManager()->callEvent(new PlayerClickHumanoidEvent($player, $target, $pk->trData->actionType));
                }
            }
        }
    }
}