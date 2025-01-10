<?php

declare(strict_types=1);

namespace lobbycraft\LobbyPM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\player\Player;
use jojoe77777\FormAPI\CustomForm;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!$this->getServer()->getPluginManager()->getPlugin("FormAPI")) {
            $this->getLogger()->warning("FormAPI not found!");
        }
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $item = Item::get(372, 0);
        $item->setCustomName("§9Settings");
        $player->getInventory()->setItem(4, $item);
    }

    public function onPlayerDropItem(PlayerDropItemEvent $event): void {
        $item = $event->getItem();
        if ($item->getCustomName() === "§9Settings") {
            $event->cancel();
        }
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($item->getCustomName() === "§9Settings") {
            $form = new CustomForm(function (Player $player, $data) {});
            $form->setTitle("Settings");
            $form->addLabel("SOON");
            $player->sendForm($form);
        }
    }
}
