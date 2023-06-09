<?php

namespace LC\commands;

use pocketmine\entity\object\ItemEntity;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as MG;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
use pocketmine\Server;
use pocketmine\plugin\Plugin;
use pocketmine\item\Item;

use LC\LobbyCore;

class HubCommand extends Command
{
    private $plugin;

    public function __construct()
    {
        parent::__construct("hub", "hub command", null, ["spawn"]);
        $this->setPermission("lobbycore.command.hub");
    }

    public function execute(CommandSender $player, string $label, array $args)
    {
        if ($player instanceof Player) {
            $this->plugin = LobbyCore::getInstance();
            $player->teleport($player->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            $player->getInventory()->clearALL();
            $player->getArmorInventory()->clearALL();
            $player->sendMessage(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Hub-Message")));
            $player->sendTitle(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Hub-Title")));

            $item1 = VanillaItems::COMPASS();
            $item1->setCustomName("Games");

            $item2 = VanillaItems::DIAMOND_AXE();
            $item2->setCustomName("Cosmeticos");

            $item3 = VanillaItems::BOOK();
            $item3->setCustomName("Informacion");


            $player->getInventory()->setItem(0, $item1);
            $player->getInventory()->setItem(4, $item2);
            $player->getInventory()->setItem(8, $item3);
        }
    }
}