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

use Vecnavium\FormsUI\Form;
use Vecnavium\FormsUI\FormAPI;
use Vecnavium\FormsUI\SimpleForm;
use LC\LobbyCore;

class EventListener implements Listener
{

    private $plugin;

    public function onJoin(PlayerJoinEvent $event)
    {

        $player = $event->getPlayer();
        $name = $player->getName();

        $event->setJoinMessage("");
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

    public function onQuit(PlayerQuitEvent $event){

        $player = $event->getPlayer();
        $name = $player->getName();

        $event->setQuitMessage("");
        Server::getInstance()->broadcastMessage(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Quit-Message")));
    }
	
    public function onClick(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $itn = $player->getInventory()->getItemInHand()->getCustomName();
        if ($itn == "Games") {
            LobbyCore::getInstance()->getUI()->getGames($player);
        }
        if ($itn == "Cosmeticos") {
            LobbyCore::getInstance()->getUI()->getCosmetics($player);
        }
        if ($itn == "Informacion") {
            LobbyCore::getInstance()->getUI()->getInfo($player);
        }
    }
}
