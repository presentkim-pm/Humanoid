<?php

namespace presentkim\humanoid\command\subcommands\simple;


use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\task\{
  PlayerTask, HumanoidSetTask
};

class SetNameCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('name');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                PlayerTask::registerTask(new class($sender, implode(' ', $args)) extends HumanoidSetTask{

                    /** @var string */
                    private $name;

                    /**
                     * @param Player $player
                     * @param string $name
                     */
                    public function __construct(Player $player, string $name){
                        parent::__construct($player);
                        $this->name = $name;
                    }

                    /** @param PlayerClickHumanoidEvent $event */
                    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
                        $event->getHumanoid()->setNameTag($this->name);
                        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-name@success', $this->name));

                        $event->setCancelled(true);
                        $this->cancel();
                    }
                });
                return true;
            } else {
                $sender->sendMessage(Plugin::$prefix . $this->usage);
                return false;
            }
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}