<?php

namespace LC\Event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as MG;
use pocketmine\plugin\Plugin;
use pocketmine\item\ItemFactory;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use Vecnavium\FormsUI\Form;
use Vecnavium\FormsUI\FormAPI;
use Vecnavium\FormsUI\SimpleForm;
use LC\LobbyCore;

class EventListener implements Listener{

    private $plugin;

    public function onJoin(PlayerJoinEvent $event){

        $player = $event->getPlayer();
        $name = $player->getName();

        $event->setJoinMessage("");
        if ($player->hasPlayedBefore()) {
            $this->plugin = LobbyCore::getInstance();
            Server::getInstance()->broadcastMessage(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Join-Message")));
            $player->teleport($player->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());

            $slot1 = ItemFactory::getInstance()->get(345, 0, 1)->setCustomName("Games");
            $slot2 = ItemFactory::getInstance()->get(54, 0, 1)->setCustomName("Cosmeticos");
		    $slot3 = ItemFactory::getInstance()->get(340, 0, 1)->setCustomName("Informacion");

            $player->getInventory()->clearAll();
            $player->getInventory()->setItem(0, $slot1);
            $player->getInventory()->setItem(4, $slot2);
            $player->getInventory()->setItem(8, $slot3);
        }

    }

    public function onQuit(PlayerQuitEvent $event){

        $player = $event->getPlayer();
        $name = $player->getName();

        $event->setQuitMessage("");
        Server::getInstance()->broadcastMessage(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Quit-Message")));
    }
	
    public function onClick(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $itn = $player->getInventory()->getItemInHand()->getCustomName();
        if($itn == "Games"){
            $this->openGames($player);
        }
        if($itn == "Cosmeticos"){
            $this->openCosmetics($player);
        }
        if($itn == "Informacion"){
            if ($player->hasPermission("lobbycore.use.cosmetics")){
            } else {
                $player->sendMessage(MG:: RED . "You not have permissions to use cosmetics");
            }
            $this->openInfo($player);
        }
    }

    public function openGames(Player $player){
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

    public function openCosmetics(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    if ($player->hasPermission("lobbycore.use.fly")){
                    } else {
                        $player->sendMessage(MG:: RED . "You not have permissions to use cosmetics fly");
                    }
                    $this->FlyForm($player);
                break;
                case 1:
                    if ($player->hasPermission("lobbycore.use.size")){
                    } else {
                        $player->sendMessage(MG::RED . "You not have permissions to use this cosmetics fly");
                    }
                    $this->SizeForm($player);
                break;
                case 3:
                break;
            }
        });
        $form->setTitle(MG::YELLOW . $this->plugin->getConfig()->get("CosmeticTitle"));
        $form->setContent(MG::RED . $this->plugin->getConfig()->get("CosmeticInfo"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("CosmeticForm1"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("CosmeticForm2"));
        $form->addButton(MG::RED . $this->plugin->getConfig()->get("CosmeticForm3"));
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

    public function openInfo(Player $player){
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
