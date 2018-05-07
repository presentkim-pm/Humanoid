<?php

namespace blugin\humanoid\listener;

use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\entity\Humanoid;
use blugin\humanoid\event\PlayerClickHumanoidEvent;

class DataPacketEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param DataPacketReceiveEvent $event */
    public function onDataPacketReceiveEvent(DataPacketReceiveEvent $event) : void{
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