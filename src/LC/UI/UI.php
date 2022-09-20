<?php

namespace LC\UI;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as MG;

use Vecnavium\FormsUI\Form;
use Vecnavium\FormsUI\FormAPI;
use Vecnavium\FormsUI\SimpleForm;

use LC\LobbyCore;

class UI {

    public $plugin;

    public function __construct(){
        $this->plugin = LobbyCore::getInstance();
    }

    public function getGames(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $this->plugin->getServer()->getCommandMap()->dispatch($player, $this->plugin->getConfig()->get("CommandForm1"));
                    break;
                case 1:
                    $this->plugin->getServer()->getCommandMap()->dispatch($player, $this->plugin->getConfig()->get("CommandForm2"));
                    break;
                case 2:
                    $this->plugin->getServer()->getCommandMap()->dispatch($player, $this->plugin->getConfig()->get("CommandForm3"));
                    break;
                case 3:
                    $this->plugin->getServer()->getCommandMap()->dispatch($player, $this->plugin->getConfig()->get("CommandForm4"));
                    break;
                case 4:
                    $this->plugin->getServer()->getCommandMap()->dispatch($player, $this->plugin->getConfig()->get("CommandForm5"));
                    break;
                case 5:
                    $this->plugin->getServer()->getCommandMap()->dispatch($player, $this->plugin->getConfig()->get("CommandForm6"));
                    break;
            }
        });
        $form->setTitle(MG::RED . $this->plugin->getConfig()->get("GameTitle"));
        $form->setContent(MG::RED . $this->plugin->getConfig()->get("GameInfo"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("GameForm1"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("GameForm2"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("GameForm3"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("GameForm4"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("GameForm5"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("GameForm6"));
        $form->addButton(MG::RED . "Cerrar");
        $form->sendToPlayer($player);
    }

    public function getCosmetics(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    if ($player->hasPermission("lobbycore.use.fly")){
                        $this->FlyForm($player);
                    } else {
                        $player->sendMessage($this->plugin->getConfig()->get("NotPermissions"));
                    }
                break;
                case 1:
                    if ($player->hasPermission("lobbycore.use.size")){
                        $this->SizeForm($player);
                    } else {
                        $player->sendMessage($this->plugin->getConfig()->get("NotPermissions"));
                    }
               break;
            }
        });
        $form->setTitle(MG::YELLOW . $this->plugin->getConfig()->get("CosmeticTitle"));
        $form->setContent(MG::RED . $this->plugin->getConfig()->get("CosmeticInfo"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("CosmeticForm1"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("CosmeticForm2"));
        $form->addButton(MG::RED . "Cerrar");
        $form->sendToPlayer($player);
    }

    public function FlyForm(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $player->setFlying(true);
                    $player->setAllowFlight(true);
                    $player->sendMessage(MG::GREEN . $this->plugin->getConfig()->get("FlyMessageTrue"));
                    $player->sendTitle(MG::GREEN . $this->plugin->getConfig()->get("FlyTitleTrue"));
                    break;
                case 1:
                    $player->setFlying(false);
                    $player->setAllowFlight(false);
                    $player->sendMessage(MG::RED . $this->plugin->getConfig()->get("FlyMessageFalse"));
                    $player->sendTitle(MG::RED . $this->plugin->getConfig()->get("FlyTitleFalse"));
                    break;
            }
        });
        $form->setTitle(MG::BLUE . $this->plugin->getConfig()->get("FlyTitle"));
        $form->setContent(MG::GRAY . $this->plugin->getConfig()->get("FlyInfo"));
        $form->addButton(MG::GREEN . $this->plugin->getConfig()->get("FlyForm1"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("FlyForm2"));
        $form->addButton(MG::RED . "Cerrar");
        $form->sendToPlayer($player);
    }

    public function SizeForm(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $player->setScale("1.0");
                    $player->sendMessage(MG::GREEN . $this->plugin->getConfig()->get("SizeMessageNormal"));
                    $player->sendTitle(MG::GREEN . $this->plugin->getConfig()->get("SizeTitleNormal"));
                    break;
                case 1:
                    $player->setScale("1.5");
                    $player->sendMessage(MG::GREEN . $this->plugin->getConfig()->get("SizeMessageMedium"));
                    $player->sendTitle(MG::GREEN . $this->plugin->getConfig()->get("SizeTitleMedium"));
                    break;
                case 2:
                    $player->setScale("2.0");
                    $player->sendMessage(MG::GREEN . $this->plugin->getConfig()->get("SizeMessageBig"));
                    $player->sendTitle(MG::GREEN . $this->plugin->getConfig()->get("SizeTitleBig"));
                    break;
            }
        });
        $form->setTitle(MG::BLUE . $this->plugin->getConfig()->get("SizeTitle"));
        $form->setContent(MG::GRAY . $this->plugin->getConfig()->get("SizeInfo"));
        $form->addButton(MG::GREEN . $this->plugin->getConfig()->get("SizeForm1"));
        $form->addButton(MG::GREEN . $this->plugin->getConfig()->get("SizeForm2"));
        $form->addButton(MG::GREEN . $this->plugin->getConfig()->get("SizeForm3"));
        $form->addButton(MG::RED . "Cerrar");
        $form->sendToPlayer($player);
    }

    public function getInfo(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    break;
            }
        });
        $form->setTitle(MG::BLUE .$this->plugin->getConfig()->get("InfoTitle"));
        $form->setContent(MG::RED . $this->plugin->getConfig()->get("Info"));
        $form->addButton(MG::RED . "Cerrar");
        $form->sendToPlayer($player);
    }
}