<?php

namespace kim\present\humanoid\inventory;

use kim\present\humanoid\entity\Humanoid;
use kim\present\humanoid\util\Utils;
use pocketmine\inventory\BaseInventory;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\{
	MobArmorEquipmentPacket, MobEquipmentPacket
};
use pocketmine\network\mcpe\protocol\types\ContainerIds;
use pocketmine\Player;

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

	/**
	 * @param Humanoid    $humanoid
	 * @param CompoundTag $tag
	 *
	 * @return HumanoidInventory
	 */
	public static function nbtDeserialize(Humanoid $humanoid, CompoundTag $tag) : HumanoidInventory{
		$inventory = new HumanoidInventory($humanoid);
		$inventory->setHelmet(Item::nbtDeserialize($tag->getCompoundTag('Helmet')));
		$inventory->setChestplate(Item::nbtDeserialize($tag->getCompoundTag('Chestplate')));
		$inventory->setLeggings(Item::nbtDeserialize($tag->getCompoundTag('Leggings')));
		$inventory->setBoots(Item::nbtDeserialize($tag->getCompoundTag('Boots')));
		$inventory->setHeldItem(Item::nbtDeserialize($tag->getCompoundTag('HeldItem')));
		return $inventory;
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setHelmet(Item $item) : bool{
		return $this->setItem(self::HELMET, $item);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setChestplate(Item $item) : bool{
		return $this->setItem(self::CHESTPLATE, $item);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setLeggings(Item $item) : bool{
		return $this->setItem(self::LEGGINGS, $item);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setBoots(Item $item) : bool{
		return $this->setItem(self::BOOTS, $item);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setHeldItem(Item $item) : bool{
		return $this->setItem(self::HELDITEM, $item);
	}

	/** @return Humanoid */
	public function getHolder() : Humanoid{
		return $this->holder;
	}

	/** @return string */
	public function getName() : string{
		return "HumanoidInventory";
	}

	/** @return int */
	public function getDefaultSize() : int{
		return 5;
	}

	/**
	 * @param int             $index
	 * @param Player|Player[] $target
	 */
	public function sendSlot(int $index, $target) : void{
		if($index === self::HELDITEM){
			$this->sendHeldItem($target);
		}else{
			$this->sendArmors($target);
		}
	}

	/** @param Player|Player[] $target */
	public function sendHeldItem($target) : void{
		if($target instanceof Player){
			$target = [$target];
		}
		$pk = new MobEquipmentPacket();
		$pk->entityRuntimeId = $this->holder->getId();
		$pk->item = $this->getHeldItem();
		$pk->inventorySlot = $pk->hotbarSlot = 0;
		$pk->windowId = ContainerIds::INVENTORY;
		$pk->encode();

		foreach($target as $player){
			$player->dataPacket($pk);
		}
	}

	/** @return Item */
	public function getHeldItem() : Item{
		return $this->getItem(self::HELDITEM);
	}

	/** @param Player|Player[] $target */
	public function sendArmors($target) : void{
		if($target instanceof Player){
			$target = [$target];
		}
		$armor = $this->getContents(true);

		$pk = new MobArmorEquipmentPacket();
		$pk->entityRuntimeId = $this->holder->getId();
		$pk->slots = $armor;
		$pk->encode();

		foreach($target as $player){
			$player->dataPacket($pk);
		}
	}

	public function canAddItem(Item $item) : bool{
		return $this->getItem($this->getIndex($item))->isNull();
	}

	public function getIndex(Item $item){
		$class = get_class($item);
		if(Utils::endsWith($class, 'Helmet') || Utils::endsWith($class, 'Cap')){
			return self::HELMET;
		}elseif(Utils::endsWith($class, 'Chestplate') || Utils::endsWith($class, 'Tunic')){
			return self::CHESTPLATE;
		}elseif(Utils::endsWith($class, 'Leggings') || Utils::endsWith($class, 'Pants')){
			return self::LEGGINGS;
		}elseif(Utils::endsWith($class, 'Boots')){
			return self::BOOTS;
		}else{
			return self::HELDITEM;
		}
	}

	public function addItem(Item ...$slots) : array{
		$itemSlots = [];
		foreach($slots as $slot){
			if($slot->isNull()){
				$itemSlots[] = clone $slot;
			}else{
				$index = $this->getIndex($slot);
				if($this->getItem($index)->isNull()){
					$this->setItem($index, $slot);
				}else{
					$itemSlots[] = clone $slot;
				}
			}
		}
		return $itemSlots;
	}

	/** @return Player[] */
	public function getViewers() : array{
		return array_merge(parent::getViewers(), $this->holder->getViewers());
	}

	/**
	 * @param string $tagName
	 *
	 * @return CompoundTag
	 */
	public function nbtSerialize(string $tagName = 'Inventory') : CompoundTag{
		return new CompoundTag($tagName, [
			$this->getHelmet()->nbtSerialize(self::HELMET, 'Helmet'),
			$this->getChestplate()->nbtSerialize(self::CHESTPLATE, 'Chestplate'),
			$this->getLeggings()->nbtSerialize(self::LEGGINGS, 'Leggings'),
			$this->getBoots()->nbtSerialize(self::BOOTS, 'Boots'),
			$this->getHeldItem()->nbtSerialize(self::HELDITEM, 'HeldItem'),
		]);
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
}