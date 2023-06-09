<?php

namespace LC\Commands;

use LC\api\ItemAPI;
use pocketmine\data\bedrock\item\BlockItemIdMap;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\StringItem;
use pocketmine\item\StringToItemParser;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender; 
use pocketmine\utils\TextFormat as MG;

class ItemCommand extends Command
{

    public function __construct()
    {
        parent::__construct("item", "back item command", null, []);
    }

    public function execute(CommandSender $player, string $label, array $args)
    {
        if ($player instanceof Player) {
            $player->getInventory()->clearALL();
            $player->getArmorInventory()->clearALL();

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