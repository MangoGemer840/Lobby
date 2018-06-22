<?php

declare(strict_types=1);

namespace Lobby\tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as C;

use Lobby\Main;

class NewLobbyTask extends PluginTask{

	private $seconds = 0;
	private $plugin;
	private $player;

	public function __construct(Main $plugin, Player $player){
		$this->plugin = $plugin;
		$this->player = $player;
	}

	public function onRun(int $tick): void{
		$player = $this->player;
		$level = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn();

		if($this->seconds == 1){
			$this->plugin->Particle($player);
			$player->sendMessage(C::GREEN . "Teleporting in 5 seconds");
		}

		if($this->seconds == 2){
			$this->plugin->Particle($player);
			$player->sendMessage(C::GREEN . "Teleporting in 4 seconds");
		}

		if($this->seconds == 3){
			$this->plugin->Particle($player);
			$player->sendMessage(C::GREEN . "Teleporting in 3 seconds");
		}

		if($this->seconds == 4){
			$this->plugin->Particle($player);
			$player->sendMessage(C::GREEN . "Teleporting in 2 seconds");
		}

		if($this->seconds == 5){
			$this->plugin->Particle($player);
			$player->sendMessage(C::GREEN . "Teleporting in 1 seconds");
			$player->sendMessage(C::GREEN . "Teleporting now....");
			$player->teleport($level);
			$this->plugin->stopTask($this->getTaskId(), "3.0.0-ALPHA12");
		}

		$this->seconds++;
	}
}