<?php

namespace presentkim\humanoid\entity;

use pocketmine\Player;
use pocketmine\entity\{
  Entity, Skin
};
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\{
  CompoundTag, ByteTag, FloatTag, StringTag
};
use pocketmine\network\mcpe\protocol\{
  AddPlayerPacket, MovePlayerPacket, PlayerSkinPacket
};
use pocketmine\utils\UUID;
use presentkim\geometryapi\GeometryAPI;
use presentkim\humanoid\inventory\HumanoidInventory;

class Humanoid extends Entity{

    /** @var UUID */
    protected $uuid;

    /** @var Skin */
    protected $skin;

    /** @var HumanoidInventory */
    protected $inventory;

    /** @var float */
    public $width = 0.6;

    /** @var float */
    public $height = 1.8;

    /** @var float */
    public $eyeHeight = 1.62;

    /** @var float */
    protected $baseOffset = 1.62;

    protected function initEntity() : void{
        parent::initEntity();

        $this->uuid = UUID::fromRandom();

        $this->inventory = new HumanoidInventory($this);
        $this->inventory->setHeldItem($this->namedtag->hasTag('HeldItem') ? Item::nbtDeserialize($this->namedtag->getCompoundTag('HeldItem')) : Item::get(Item::AIR));

        if ($this->namedtag->hasTag('Skin')) {
            $skinTag = $this->namedtag->getCompoundTag('Skin');
            $skinData = $skinTag->getString('SkinData');
            $capeData = $skinTag->getString('CapeData');
            $geometryName = $skinTag->getString('GeometryName');
        } else {
            $skinData = $this->namedtag->hasTag('SkinData') ? $this->namedtag->getString('SkinData') : str_repeat("\x00", 8192);
            $capeData = '';
            $geometryName = $this->namedtag->hasTag('GeometryName') ? $this->namedtag->getString('GeometryName') : '';

            $this->namedtag->removeTag('SkinData');
            $this->namedtag->removeTag('GeometryName');
        }
        $this->setSkin(new Skin('humanoid', $skinData, $capeData, $geometryName));
        $this->setSneaking($this->namedtag->hasTag('Sneak') ? (bool) $this->namedtag->getByte('Sneak') : false);
        $this->setScale($this->namedtag->hasTag('Scale') ? $this->namedtag->getFloat('Scale') : 1);
    }

    /** @return UUID */
    public function getUniqueId() : UUID{
        return $this->uuid;
    }

    /** @return HumanoidInventory */
    public function getInventory() : HumanoidInventory{
        return $this->inventory;
    }

    /** @return Skin */
    public function getSkin() : Skin{
        return $this->skin;
    }

    /** @param Skin $skin */
    public function setSkin(Skin $skin) : void{
        if (!$skin->isValid()) {
            throw new \InvalidStateException('Specified skin is not valid, must be 8KiB or 16KiB');
        }

        if (empty($skin->getGeometryData()) && class_exists(GeometryAPI::class)) {
            $geometryData = GeometryAPI::getInstance()->getGeometryData($geometryName = $skin->getGeometryName()) ?? '';
            $skin = new Skin($skin->getSkinId(), $skin->getSkinData(), $skin->getCapeData(), $geometryName, $geometryData);
        }
        $this->skin = $skin;
        $this->skin->debloatGeometryData();
        $this->sendSkin($this->getViewers());
    }

    /** @param Player[] | null $targets */
    public function sendSkin(array $targets = null) : void{
        $pk = new PlayerSkinPacket();
        $pk->uuid = $this->getUniqueId();
        $pk->skin = $this->skin;
        $this->server->broadcastPacket($targets ?? $this->hasSpawned, $pk);
    }

    public function saveNBT() : void{
        parent::saveNBT();

        $this->namedtag->setTag($this->inventory->getHeldItem()->nbtSerialize(-1, 'HeldItem'));
        $this->namedtag->setTag(new CompoundTag('Skin', [
          new StringTag('SkinData', $this->skin->getSkinData()),
          new StringTag('CapeData', $this->skin->getCapeData()),
          new StringTag('GeometryName', $this->skin->getGeometryName()),
        ]));
        $this->namedtag->setTag(new ByteTag('Sneak', (int) $this->isSneaking()));
        $this->namedtag->setTag(new FloatTag('Scale', $this->getScale()));
    }

    /** @param \pocketmine\Player $player */
    protected function sendSpawnPacket(Player $player) : void{
        if (!$this->skin->isValid()) {
            throw new \InvalidStateException((new \ReflectionClass($this))->getShortName() . ' must have a valid skin set');
        }

        $pk = new AddPlayerPacket();
        $pk->uuid = $this->getUniqueId();
        $pk->username = $this->getNameTag();
        $pk->entityRuntimeId = $this->id;
        $pk->position = $this->asVector3();
        $pk->motion = null;
        $pk->yaw = $this->yaw;
        $pk->pitch = $this->pitch;
        $pk->item = $this->inventory->getHeldItem();
        $pk->metadata = $this->propertyManager->getAll();
        $player->dataPacket($pk);

        $this->sendSkin([$player]);
    }

    /** @param EntityDamageEvent $source */
    public function attack(EntityDamageEvent $source) : void{
        $source->setCancelled(true);
    }

    /**
     * @param float $dx
     * @param float $dy
     * @param float $dz
     *
     * @return bool
     */
    public function move(float $dx, float $dy, float $dz) : bool{
        return false;
    }

    /**
     * @param Vector3    $pos
     * @param float|null $yaw
     * @param float|null $pitch
     *
     * @return bool
     */
    public function teleport(Vector3 $pos, float $yaw = null, float $pitch = null) : bool{
        if (parent::teleport($pos, $yaw, $pitch)) {
            $yaw = $yaw ?? $this->yaw;
            $pitch = $pitch ?? $this->pitch;

            $pk = new MovePlayerPacket();
            $pk->entityRuntimeId = $this->getId();
            $pk->position = $this->getOffsetPosition($pos);
            $pk->pitch = $pitch;
            $pk->headYaw = $yaw;
            $pk->yaw = $yaw;
            $pk->mode = MovePlayerPacket::MODE_TELEPORT;

            $this->server->broadcastPacket($targets ?? $this->hasSpawned, $pk);
            $this->spawnToAll();
            return true;
        }
        return false;
    }
}
