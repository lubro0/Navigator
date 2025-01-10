<?php

declare(strict_types=1);

namespace lobbycraft\LobbyPM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class Main extends PluginBase implements Listener {

    private array $got_items = [];

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $this->got_items[$player->getName()] = false;
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        if (!$this->got_items[$player->getName()]) {
            $rod = VanillaItems::BLAZE_ROD();
            $rod->setCustomName("§9Ranks");
            $rod->setUnbreakable(true);  // Set the item to be unbreakable
            $player->getInventory()->setItem(3, $rod);
            $this->got_items[$player->getName()] = true;
        }
    }

    public function onPlayerDropItem(PlayerDropItemEvent $event): void {
        $item = $event->getItem();
        if ($item->getCustomName() === "§9Ranks") {
            $event->cancel();  // Prevent dropping the item
        }
    }
}
