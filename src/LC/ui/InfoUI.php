<?php

namespace LC\ui;

use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat as MG;

use Forms\FormAPI\SimpleForm;

use LC\LobbyCore;

class InfoUI
{

    public $plugin;

    use SingletonTrait;

    public function __construct(){
        $this->plugin = LobbyCore::getInstance();
        self::setInstance($this);
    }

    public function getInfoUI(Player $player)
    {
        $form = new SimpleForm(function (Player $player, int $data = null) {
            if ($data === null) {
                return true;
            }
            switch ($data) {
                case 0:
                    break;
            }
        });
        $form->setTitle(MG::BLUE . $this->plugin->getConfig()->get("InfoTitle"));
        $form->setContent(MG::RED . $this->plugin->getConfig()->get("Info"));
        $form->addButton(MG::RED . "Cerrar");
        $form->sendToPlayer($player);
    }
}
