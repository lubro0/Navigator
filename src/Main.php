<?php

declare(strict_types=1);

namespace lubro\Navigator;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $player->setMetadata("hasMoved", false);
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        if (!$player->getMetadata("hasMoved") && $player->getLocation() !== $event->getFrom()) {
            $compass = VanillaItems::COMPASS();
            $compass->setCustomName("§eNavigator");
            $player->getInventory()->setItem(4, $compass);
            $player->setMetadata("hasMoved", true);
        }
    }

    public function onPlayerDropItem(PlayerDropItemEvent $event): void {
        $item = $event->getItem();
        if ($item->getCustomName() === "§eNavigator") {
            $event->cancel();
        }
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($item->getCustomName() === "§eNavigator") {
            $form = new CustomForm(function (Player $player, $data) {});
            $form->setTitle("Navigator");
            $form->addLabel("SOON");
            $player->sendForm($form);
        }
    }
}
