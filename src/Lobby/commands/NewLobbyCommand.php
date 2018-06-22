<?php

declare(strict_types=1);

namespace Lobby\commands;

use pocketmine\Player;
use pocketmine\command\{
    CommandSender, ConsoleCommandSender, PluginCommand
};
use pocketmine\utils\TextFormat as C;

use Lobby\Main;

class NewLobbyCommand extends PluginCommand{

    public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("D");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        Main::get()->startTask($sender, "3.0.0");
        return true;
    }
}