<?php

namespace presentkim\humanoid\inventory;

use pocketmine\inventory\BaseInventory;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\MobArmorEquipmentPacket;
use pocketmine\network\mcpe\protocol\MobEquipmentPacket;
use pocketmine\network\mcpe\protocol\types\ContainerIds;
use pocketmine\Player;
use presentkim\humanoid\entity\Humanoid;

class HumanoidInventory extends BaseInventory{

    public const HELMET = 0;
    public const CHESTPLATE = 1;
    public const LEGGINGS = 2;
    public const BOOTS = 3;
    public const HELDITEM = 4;

    /** @var Humanoid */
    protected $holder;

    public function __construct(Humanoid $holder){
        $this->holder = $holder;
        parent::__construct();
    }

    public function getHolder() : Humanoid{
        return $this->holder;
    }

    public function getName() : string{
        return "HumanoidInventory";
    }

    public function getDefaultSize() : int{
        return 5;
    }

    /** @return Item */
    public function getHelmet() : Item{
        return $this->getItem(self::HELMET);
    }

    /** @return Item */
    public function getChestplate() : Item{
        return $this->getItem(self::CHESTPLATE);
    }

    /** @return Item */
    public function getLeggings() : Item{
        return $this->getItem(self::LEGGINGS);
    }

    /** @return Item */
    public function getBoots() : Item{
        return $this->getItem(self::BOOTS);
    }

    /** @return Item */
    public function getHeldItem() : Item{
        return $this->getItem(self::HELDITEM);
    }

    public function setHelmet(Item $item) : bool{
        return $this->setItem(self::HELMET, $item);
    }

    public function setChestplate(Item $item) : bool{
        return $this->setItem(self::CHESTPLATE, $item);
    }

    public function setLeggings(Item $item) : bool{
        return $this->setItem(self::LEGGINGS, $item);
    }

    public function setBoots(Item $item) : bool{
        return $this->setItem(self::BOOTS, $item);
    }

    public function setHeldItem(Item $item) : bool{
        return $this->setItem(self::HELDITEM, $item);
    }

    public function sendSlot(int $index, $target) : void{
        if ($index === self::HELDITEM) {
            $this->sendHeldItem($target);
        } else {
            $this->sendArmors($target);
        }
    }

    public function sendArmors($target) : void{
        if ($target instanceof Player) {
            $target = [$target];
        }
        $armor = $this->getContents(true);

        $pk = new MobArmorEquipmentPacket();
        $pk->entityRuntimeId = $this->holder->getId();
        $pk->slots = $armor;
        $pk->encode();

        foreach ($target as $player) {
            $player->dataPacket($pk);
        }
    }

    public function sendHeldItem($target) : void{
        if ($target instanceof Player) {
            $target = [$target];
        }
        $pk = new MobEquipmentPacket();
        $pk->entityRuntimeId = $this->holder->getId();
        $pk->item = $this->getHeldItem();
        $pk->inventorySlot = $pk->hotbarSlot = 0;
        $pk->windowId = ContainerIds::INVENTORY;
        $pk->encode();

        foreach ($target as $player) {
            $player->dataPacket($pk);
        }
    }

    /** @return Player[] */
    public function getViewers() : array{
        return array_merge(parent::getViewers(), $this->holder->getViewers());
    }
}