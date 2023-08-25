<?php

namespace LC\event;

use LC\api\ItemManager;
use LC\block\RegisterBlocks;
use LC\ui\CosmeticsUI;
use LC\ui\GamesUI;
use LC\ui\InfoUI;
use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\data\bedrock\item\BlockItemIdMap;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as MG;
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
        $this->plugin = LobbyCore::getInstance();

        $event->setJoinMessage("");
        Server::getInstance()->broadcastMessage(str_replace(["{player}"], [$name], $this->plugin->getConfig()->get("Join-Message")));
        $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());

        $item1 = VanillaItems::COMPASS();
        $item1->setCustomName($this->plugin->getConfig()->get("Games-Item"));

        $item2 = VanillaBlocks::CHEST()->asItem();
        $item2->setCustomName($this->plugin->getConfig()->get("Cosmetics-Item"));

        $item3 = VanillaItems::BOOK();
        $item3->setCustomName($this->plugin->getConfig()->get("Info-Item"));


        $player->getInventory()->setItem(0, $item1);
        $player->getInventory()->setItem(4, $item2);
        $player->getInventory()->setItem(8, $item3);
    }

    public function onQuit(PlayerQuitEvent $event){

        $player = $event->getPlayer();
        $name = $player->getName();

        $event->setQuitMessage("");
        Server::getInstance()->broadcastMessage(str_replace(["{player}"], [$name], $this->plugin->getConfig()->get("Quit-Message")));
    }
	
    public function onClick(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $itn = $player->getInventory()->getItemInHand()->getCustomName();
        if ($itn == "Games") {
            GamesUI::getInstance()->getGamesUI($player);
        }
        if ($itn == "Cosmeticos") {
            CosmeticsUI::getInstance()->getCosmeticsUI($player);
        }
        if ($itn == "Informacion") {
            InfoUI::getInstance()->getInfoUI($player);
        }
    }
}
