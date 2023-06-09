<?php

namespace LC;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as MG;

//Events

use LC\event\EventListener;
use LC\event\Protection;

//Commands

use LC\commands\HubCommand;
use LC\commands\ItemCommand;

//Uis

use LC\ui\UI;

class LobbyCore extends PluginBase implements Listener {

    private static $instance;
	
	public function onLoad() : void {
		self::$instance = $this;
	}

    public function onEnable(): void {
        $this->getLogger()->info(MG::GREEN . "LobbyCore enabled successfully, plugin made by JuanantonioVYT for MegaHost community");
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Protection(), $this);
        $this->getServer()->getCommandMap()->register("/hub", new HubCommand());
        $this->saveResource("config.yml");
    }

    public function onDisable(): void {

    }

    public static function getInstance() : LobbyCore {
        return self::$instance;
    }

    public static function getUI() : UI {
        return new UI();
    }
}