<?php

namespace presentkim\humanoid\task;


use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use presentkim\humanoid\HumanoidMain as Plugin;

abstract class PlayerTask{

    /** @var PlayerTask[] */
    private static $tasks = [];

    /** @return PlayerTask[] */
    public static function getTasks(){
        return PlayerTask::$tasks;
    }

    /**
     * @param Player $player
     *
     * @return PlayerTask | null
     */
    public static function getTask(Player $player){
        return PlayerTask::$tasks[$player->getLowerCaseName()] ?? null;
    }

    /** @param PlayerTask $task */
    public static function registerTask(PlayerTask $task){
        PlayerTask::$tasks[$task->getKey()] = $task;
    }

    /** @param PlayerTask $task */
    public static function cancelTask(PlayerTask $task){
        unset(PlayerTask::$tasks[$task->getKey()]);
    }

    public static function cancelAllTask(){
        PlayerTask::$tasks = [];
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