<?php

declare(strict_types=1);

namespace Lobby;

use pocketmine\level\particle\FlameParticle;
use pocketmine\plugin\PluginBase;

use Lobby\commands\{
	NewLobbyCommand, OldLobbyCommand
};
use Lobby\tasks\{
	NewLobbyTask, OldLobbyTask
};

class Main extends PluginBase{

	private static $instance;
	private $newtask = [];
	private $oldtask = [];

	public function onEnable(){
		self::$instance = $this;
		if($this->getServer()->getApiVersion() == "3.0.0-ALPHa12") $this->getServer()->getCommandMap()->register("lobby", new OldLobbyCommand("lobby", $this));
		if($this->getServer()->getApiVersion() == "3.0.0" && $this->getServer()->getApiVersion() == "3.0.1") $this->getServer()->getCommandMap()->register("lobby", new NewLobbyCommand("lobby", $this));
	}

	public static function get(): self{
		return self::$instance;
	}

	public function startTask($player, string $task){
		if($task == "3.0.0"){
			$task = new NewLobbyTask($this, $player);
			$h = $this->getScheduler()->scheduleRepeatingTask($task, 20);
			$task->setHandler($h);
			$this->newtask[$task->getTaskId()] = $task->getTaskId();
		}

		if($task == "3.0.0-ALPHA12"){
			$task = new OldLobbyTask($this, $player);
			$h = $this->getServer()->getScheduler()->scheduleRepeatingTask($task, 20);
			$task->setHandler($h);
			$this->oldtask[$task->getTaskId()] = $task->getTaskId();
		}
	}

	public function stopTask($id, string $task){
		if($task == "3.0.0"){
			unset($this->newtask[$id]);
			$this->getScheduler()->cancelTask($id);
		}

		if($task == "3.0.0-ALPHA12"){
			unset($this->oldtask[$id]);
			$this->getServer()->getScheduler()->cancelTask($id);
		}
	}

	public function Particle($player){
		$level = $this->getServer()->getDefaultLevel();

		for($yaw = 0; $yaw <= 10; $yaw += 0.5){
			$x = 0.5 * sin($yaw);
			$y = 0.5;
			$z = 0.5 * cos($yaw);
			$level->addParticle(new FlameParticle($player->add($x, $y, $z)));
		}
	}
}