<?php

namespace LC\Commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as MG;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
use pocketmine\Server;
use pocketmine\plugin\Plugin;
use pocketmine\item\ItemFactory;
use pocketmine\item\Item;

class HubCommand extends Command {
  
  public function __construct(){
    parent::__construct("hub", "hub command", null, ["spawn"]);
  }
  
  public function execute(CommandSender $player, string $label, array $args){
    if($player instanceof Player){
       $player->teleport($player->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
       $player->getInventory()->clearALL();
       $player->getArmorInventory()->clearALL();
       $player->sendMessage(MG::GREEN . "Volviste al lobby" . MG::YELLOW . $player->getName());

       $slot1 = ItemFactory::getInstance()->get(401, 0, 1)->setCustomName("Games");
       $slot2 = ItemFactory::getInstance()->get(401, 0, 1)->setCustomName("Cosmeticos");
		   $slot3 = ItemFactory::getInstance()->get(403, 0, 1)->setCustomName("Informacion");

       $player->getInventory()->clearAll();
       $player->getInventory()->setItem(0, $slot1);
       $player->getInventory()->setItem(4, $slot2);
       $player->getInventory()->setItem(8, $slot3);
    }
}
}