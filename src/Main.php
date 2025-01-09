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
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener {

    private array $compass_get = [];

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $this->compass_get[$player->getName()] = false;
        $player->setAllowFlight(true);
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        if ($player->getLocation() !== $event->getFrom() && !$this->compass_get[$player->getName()]) {
            $compass = VanillaItems::COMPASS();
            $compass->setCustomName("§eNavigator");
            $player->getInventory()->setItem(4, $compass);
            $this->compass_get[$player->getName()] = true;
            $player->setAllowFlight(false);
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
            $form = new SimpleForm(function (Player $player, $data) {
                if ($data === 0) {
                    $player->sendMessage("Soon!");
                }
            });
            $form->setTitle("Navigator");
            $form->addButton("SMP");
            $player->sendForm($form);
        }
    }
}
