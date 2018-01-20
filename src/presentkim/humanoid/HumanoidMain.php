<?php

namespace presentkim\humanoid;

use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use presentkim\humanoid\listener\DataPacketEventListener;
use presentkim\humanoid\listener\PlayerEventListener;
use presentkim\humanoid\entity\Humanoid;
use presentkim\humanoid\util\Translation;
use presentkim\humanoid\command\PoolCommand;
use presentkim\humanoid\command\subcommands\{
  AddSubCommand, SetSubCommand, RemoveSubCommand, LangSubCommand, ReloadSubCommand
};

class HumanoidMain extends PluginBase{

    /** @var self */
    private static $instance = null;

    /** @return self */
    public static function getInstance(){
        return self::$instance;
    }

    /** @var string */
    public static $prefix = '';

    /** @var PoolCommand */
    private $command;

    /** @var array */
    public $task = [];

    public function onLoad(){
        if (self::$instance === null) {
            self::$instance = $this;
            $this->getServer()->getLoader()->loadClass('presentkim\humanoid\util\Utils');
            Translation::loadFromResource($this->getResource('lang/eng.yml'), true);

            Entity::registerEntity(Humanoid::class, true, [
              'Humanoid',
              'presentkim:humanoid',
            ]);
        }
    }

    public function onEnable(){
        $this->load();
        $this->getServer()->getPluginManager()->registerEvents(new DataPacketEventListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);
    }

    public function load(){
        $dataFolder = $this->getDataFolder();
        if (!file_exists($dataFolder)) {
            mkdir($dataFolder, 0777, true);
        }
        $langfilename = $dataFolder . 'lang.yml';
        if (!file_exists($langfilename)) {
            $resource = $this->getResource('lang/eng.yml');
            fwrite($fp = fopen("{$dataFolder}lang.yml", "wb"), $contents = stream_get_contents($resource));
            fclose($fp);
            Translation::loadFromContents($contents);
        } else {
            Translation::load($langfilename);
        }

        self::$prefix = Translation::translate('prefix');
        $this->reloadCommand();
    }

    public function reloadCommand(){
        if ($this->command == null) {
            $this->command = new PoolCommand($this, 'humanoid');
            $this->command->createSubCommand(AddSubCommand::class);
            $this->command->createSubCommand(SetSubCommand::class);
            $this->command->createSubCommand(RemoveSubCommand::class);
            $this->command->createSubCommand(LangSubCommand::class);
            $this->command->createSubCommand(ReloadSubCommand::class);
        }
        $this->command->updateTranslation();
        $this->command->updateSudCommandTranslation();
        if ($this->command->isRegistered()) {
            $this->getServer()->getCommandMap()->unregister($this->command);
        }
        $this->getServer()->getCommandMap()->register(strtolower($this->getName()), $this->command);
    }
}
