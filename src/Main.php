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
            $item = VanillaItems::RECORD_WAIT();
            $item->setCustomName("§9Settings");
            $player->getInventory()->setItem(4, $item);

            $this->got_items[$player->getName()] = true;
        }
    }

    public function onPlayerDropItem(PlayerDropItemEvent $event): void {
        $item = $event->getItem();
        if ($item->getCustomName() === "§9Settings") {
            $event->cancel();
        }
    }
}
