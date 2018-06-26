<?php

namespace kim\present\humanoid;

use kim\present\humanoid\command\PoolCommand;
use kim\present\humanoid\command\subcommands\{
	AddSubCommand, CancelSubCommand, CopySubCommand, LangSubCommand, ReloadSubCommand, RemoveSubCommand, SetSubCommand, SkinStealSubCommand
};
use kim\present\humanoid\entity\Humanoid as HumanoidEntity;
use kim\present\humanoid\listener\DataPacketEventListener;
use kim\present\humanoid\listener\PlayerEventListener;
use kim\present\humanoid\util\Translation;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;

class Humanoid extends PluginBase{
	/**
	 * @var string
	 */
	public static $prefix = '';

	/**
	 * @var Humanoid
	 */
	private static $instance = null;

	/** @return Humanoid */
	public static function getInstance() : Humanoid{
		return self::$instance;
	}

	/**
	 * @var PoolCommand
	 */
	private $command;

	public function onLoad() : void{
		if(self::$instance === null){
			self::$instance = $this;
			Translation::loadFromResource($this->getResource('lang/eng.yml'), true);

			Entity::registerEntity(HumanoidEntity::class, true, [
				'Humanoid',
				'PresentKim:humanoid',
			]);
		}
	}

	public function onEnable() : void{
		$dataFolder = $this->getDataFolder();
		if(!file_exists($dataFolder)){
			mkdir($dataFolder, 0777, true);
		}
		$langfilename = $dataFolder . 'lang.yml';
		if(!file_exists($langfilename)){
			$resource = $this->getResource('lang/eng.yml');
			fwrite($fp = fopen("{$dataFolder}lang.yml", "wb"), $contents = stream_get_contents($resource));
			fclose($fp);
			Translation::loadFromContents($contents);
		}else{
			Translation::load($langfilename);
		}

		self::$prefix = Translation::translate('prefix');

		if($this->command == null){
			$this->command = new PoolCommand($this, 'humanoid');
			$this->command->createSubCommand(AddSubCommand::class);
			$this->command->createSubCommand(SetSubCommand::class);
			$this->command->createSubCommand(RemoveSubCommand::class);
			$this->command->createSubCommand(CopySubCommand::class);
			$this->command->createSubCommand(CancelSubCommand::class);
		}
		$this->command->updateTranslation();
		$this->command->updateSudCommandTranslation();
		if($this->command->isRegistered()){
			$this->getServer()->getCommandMap()->unregister($this->command);
		}
		$this->getServer()->getCommandMap()->register(strtolower($this->getName()), $this->command);

		foreach(SetSubCommand::getSubCommands() as $key => $value){
			$value->updateTranslation();
		}

		$this->getServer()->getPluginManager()->registerEvents(new DataPacketEventListener(), $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);
	}

	/**
	 * @param string $name = ''
	 *
	 * @return PoolCommand
	 */
	public function getCommand(string $name = '') : PoolCommand{
		return $this->command;
	}

	/** @param PoolCommand $command */
	public function setCommand(PoolCommand $command) : void{
		$this->command = $command;
	}
}
