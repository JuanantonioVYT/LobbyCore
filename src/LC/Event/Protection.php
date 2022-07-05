<?php

namespace LC\Event;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as Color;
use pocketmine\utils\Config;

use LC\LobbyCore;

class Protection implements \pocketmine\event\Listener {

	public function onDamage(\pocketmine\event\entity\EntityDamageEvent $ev) {
		$pl = $ev->getEntity();
		if ($pl->getWorld() === Server::getInstance ()->getWorldManager()->getDefaultWorld()) {
			$ev->cancel(true);
		}
	}
	
	public function onExplosion(\pocketmine\event\entity\ExplosionPrimeEvent $ev) {
		$ev->cancel(true);
		
	}
	
	public function onBreak(\pocketmine\event\block\BlockBreakEvent $ev) {
		$pl = $ev->getPlayer();
		if ($pl->getWorld() === Server::getInstance ()->getWorldManager()->getDefaultWorld()) {
			if ($pl->hasPermission("lobbycore.actions")) {
				$ev->cancel(false);
			} else {
				$ev->cancel(true);
				$pl->sendPopup("§cYou have don't permissions for break blocks");
            }
		}
	}
	
	public function onPlace(\pocketmine\event\block\BlockPlaceEvent $ev) {
		$pl = $ev->getPlayer();
		if ($pl->getWorld() === Server::getInstance ()->getWorldManager()->getDefaultWorld()) {
			if ($pl->hasPermission("lobbycore.actions")) {
				$ev->cancel(false);
			} else {
				$ev->cancel(true);
				$pl->sendPopup("§cYou have don't permissions for place blocks");
			}
		}
	}
	
	public function onDrop(\pocketmine\event\player\PlayerDropItemEvent $ev) {
		$pl = $ev->getPlayer();
		if ($pl->getWorld() === Server::getInstance ()->getWorldManager()->getDefaultWorld()) {
			$ev->cancel(true);
		}
	}

	public function onExhaust(\pocketmine\event\player\PlayerExhaustEvent $ev) {
		$pl = $ev->getPlayer();
		if ($pl->getWorld() === Server::getInstance ()->getWorldManager()->getDefaultWorld()) {
			$ev->cancel(true);
		}
	}
}