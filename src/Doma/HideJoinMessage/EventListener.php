<?php
declare(strict_types=1);

namespace Doma\HideJoinMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener {

    public function __construct(private readonly Main $plugin) {}

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();

        if (!($this->plugin->opException() && $player->hasPermission("hidejoinmessage.see"))) {
            if ($this->plugin->hideJoin()) {
                $msg = $this->plugin->joinMsg();
                $event->setJoinMessage($msg === "" ? "" : str_replace("{player}", $player->getName(), $msg));
            }
        }

        if ($this->plugin->welcomeEnabled()) {
            $player->sendMessage(str_replace("{player}", $player->getName(), $this->plugin->welcomeMsg()));
        }
    }

    public function onQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();

        if ($this->plugin->opException() && $player->hasPermission("hidejoinmessage.see")) return;

        if ($this->plugin->hideLeave()) {
            $msg = $this->plugin->leaveMsg();
            $event->setQuitMessage($msg === "" ? "" : str_replace("{player}", $player->getName(), $msg));
        }
    }
}
