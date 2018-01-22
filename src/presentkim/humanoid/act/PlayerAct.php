<?php

namespace presentkim\humanoid\act;


use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;

abstract class PlayerAct{

    /** @var PlayerAct[] */
    private static $tasks = [];

    /** @return PlayerAct[] */
    public static function getTasks(){
        return PlayerAct::$tasks;
    }

    /**
     * @param Player $player
     *
     * @return PlayerAct | null
     */
    public static function getTask(Player $player){
        return PlayerAct::$tasks[$player->getLowerCaseName()] ?? null;
    }

    /** @param PlayerAct $task */
    public static function registerTask(PlayerAct $task){
        PlayerAct::$tasks[$task->getKey()] = $task;
    }

    /** @param PlayerAct $task */
    public static function cancelTask(PlayerAct $task){
        unset(PlayerAct::$tasks[$task->getKey()]);
    }

    public static function cancelAllTask(){
        PlayerAct::$tasks = [];
    }

    /** @var Player */
    protected $player;

    /** @var int */
    protected $id;

    /** @param \pocketmine\Player $player */
    public function __construct(Player $player){
        $this->player = $player;
    }

    /** @param PlayerInteractEvent $event */
    public function onInteract(PlayerInteractEvent $event){
        $this->cancel();
    }

    public function register(){
        self::registerTask($this);
    }

    public function cancel(){
        self::cancelTask($this);
    }

    /** @return string */
    public function getKey(){
        return $this->player->getLowerCaseName();
    }
}