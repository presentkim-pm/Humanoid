<?php

namespace kim\presenthumanoid\command;

use kim\presenthumanoid\util\{
	Translation, Utils
};
use pocketmine\command\CommandSender;

abstract class SimpleSubCommand{

	/** @var string */
	public $uname;

	/** @var string */
	protected $label;

	/** @var string[] */
	protected $aliases;

	/** @var string */
	protected $usage;

	/**
	 * SubCommand constructor.
	 *
	 * @param string $uname ;
	 */
	public function __construct(string $uname){
		$this->uname = $uname;

		$this->updateTranslation();
	}

	public function updateTranslation() : void{
		$this->label = Translation::translate("command-humanoid-set-{$this->uname}");
		$this->aliases = Translation::getArray("command-humanoid-set-{$this->uname}@aliases");
		$this->usage = Translation::translate("command-humanoid-set-{$this->uname}@usage");
	}

	/**
	 * @param CommandSender $sender
	 * @param String[]      $args
	 *
	 * @return bool
	 */
	abstract public function onCommand(CommandSender $sender, array $args) : bool;

	/**
	 * @param string $label
	 *
	 * @return bool
	 */
	public function checkLabel(string $label) : bool{
		return strcasecmp($label, $this->label) === 0 || $this->aliases && Utils::in_arrayi($label, $this->aliases);
	}

	/** @return string */
	public function getLabel() : string{
		return $this->label;
	}

	/** @param string $label */
	public function setLabel(string $label) : void{
		$this->label = $label;
	}

	/** @return string[] */
	public function getAliases() : array{
		return $this->aliases;
	}

	/** @param string[] $aliases */
	public function setAliases(array $aliases) : void{
		$this->aliases = $aliases;
	}

	/**  @return string */
	public function getUsage() : string{
		return $this->usage;
	}

	/**  @param string $usage */
	public function setUsage(string $usage) : void{
		$this->usage = $usage;
	}
}