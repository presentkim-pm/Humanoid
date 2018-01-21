<?php

namespace presentkim\humanoid\command;

use pocketmine\command\CommandSender;
use function presentkim\humanoid\util\in_arrayi;
use presentkim\humanoid\util\Translation;

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

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    abstract public function onCommand(CommandSender $sender, array $args);

    /**
     * @param string $label
     *
     * @return bool
     */
    public function checkLabel(string $label){
        return strcasecmp($label, $this->label) === 0 || $this->aliases && in_arrayi($label, $this->aliases);
    }

    /** @return string */
    public function getLabel(){
        return $this->label;
    }

    /** @param string $label */
    public function setLabel(string $label){
        $this->label = $label;
    }

    /** @return string[] */
    public function getAliases(){
        return $this->aliases;
    }

    /** @param string[] $aliases */
    public function setAliases(array $aliases){
        $this->aliases = $aliases;
    }

    /**  @return string */
    public function getUsage(){
        return $this->usage;
    }

    /**  @param string $usage */
    public function setUsage(string $usage){
        $this->usage = $usage;
    }

    public function updateTranslation(){
        $this->label = Translation::translate("command-humanoid-set-{$this->uname}");
        $this->aliases = Translation::getArray("command-humanoid-set-{$this->uname}@aliases");
        $this->usage = Translation::translate("command-humanoid-set-{$this->uname}@usage");
    }
}