<?php

namespace presentkim\humanoid\command;

use pocketmine\command\CommandSender;
use function presentkim\humanoid\util\in_arrayi;

abstract class SimpleSubCommand{

    /** @var string */
    protected $label;

    /** @var string[] */
    protected $aliases;

    /** @var string */
    protected $usage;

    /**
     * SubCommand constructor.
     *
     * @param string   $label
     * @param string[] $aliases
     */
    public function __construct(string $label, array $aliases){
        $this->label = $label;
        $this->aliases = $aliases;
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

}