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
        $plugin = $this->plugin;
        $exempt = $plugin->opException() && $player->hasPermission("hidejoinmessage.see");

        if (!$exempt) {
            $msg = $plugin->joinMsg();
            if ($msg !== "") {
                $event->setJoinMessage(str_replace("{player}", $player->getName(), $msg));
            } elseif ($plugin->hideJoin()) {
                $event->setJoinMessage("");
            }
        }

        if ($plugin->welcomeEnabled()) {
            $player->sendMessage(str_replace("{player}", $player->getName(), $plugin->welcomeMsg()));
        }
    }

    public function onQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        $plugin = $this->plugin;
        $exempt = $plugin->opException() && $player->hasPermission("hidejoinmessage.see");

        if (!$exempt) {
            $msg = $plugin->leaveMsg();
            if ($msg !== "") {
                $event->setQuitMessage(str_replace("{player}", $player->getName(), $msg));
            } elseif ($plugin->hideLeave()) {
                $event->setQuitMessage("");
            }
        }
    }
}
