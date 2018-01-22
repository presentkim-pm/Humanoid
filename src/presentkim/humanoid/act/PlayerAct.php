<?php

namespace presentkim\humanoid\act;

use pocketmine\Player;

abstract class PlayerAct{

    /** @var PlayerAct[] */
    private static $acts = [];

    /** @return PlayerAct[] */
    public static function getActs(){
        return PlayerAct::$acts;
    }

    /**
     * @param Player $player
     *
     * @return PlayerAct | null
     */
    public static function getAct(Player $player){
        return PlayerAct::$acts[$player->getLowerCaseName()] ?? null;
    }

    /** @param PlayerAct $task */
    public static function registerAct(PlayerAct $task){
        PlayerAct::$acts[$task->getKey()] = $task;
    }

    /** @param PlayerAct $task */
    public static function cancelAct(PlayerAct $task){
        unset(PlayerAct::$acts[$task->getKey()]);
    }

    public static function cancelAllAct(){
        PlayerAct::$acts = [];
    }

    /** @var Player */
    protected $player;

    /** @var int */
    protected $id;

    /** @param \pocketmine\Player $player */
    public function __construct(Player $player){
        $this->player = $player;
    }

    public function register(){
        self::registerAct($this);
    }

    public function cancel(){
        self::cancelAct($this);
    }

    /** @return string */
    public function getKey(){
        return $this->player->getLowerCaseName();
    }
}