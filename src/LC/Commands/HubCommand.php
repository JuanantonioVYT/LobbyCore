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

use LC\LobbyCore;

class HubCommand extends Command {
  
  private $plugin;

  public function __construct(){
    parent::__construct("hub", "hub command", null, ["spawn"]);
  }
  
  public function execute(CommandSender $player, string $label, array $args){
    if($player instanceof Player){
       $this->plugin = LobbyCore::getInstance();
       $player->teleport($player->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
       $player->getInventory()->clearALL();
       $player->getArmorInventory()->clearALL();
       $player->sendMessage(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Hub-Message")));
       $player->sendTitle(str_replace(["{player}"], [$player->getName()], $this->plugin->getConfig()->get("Hub-Title")));

       $slot1 = ItemFactory::getInstance()->get(345, 0, 1)->setCustomName("Games");
       $slot2 = ItemFactory::getInstance()->get(54, 0, 1)->setCustomName("Cosmeticos");
		   $slot3 = ItemFactory::getInstance()->get(340, 0, 1)->setCustomName("Informacion");

       $player->getInventory()->setItem(0, $slot1);
       $player->getInventory()->setItem(4, $slot2);
       $player->getInventory()->setItem(8, $slot3);
    }
}
}