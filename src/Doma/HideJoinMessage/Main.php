<?php
declare(strict_types=1);

namespace Doma\HideJoinMessage;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private bool $hideJoin;
    private bool $hideLeave;
    private string $customJoin;
    private string $customLeave;
    private bool $opException;
    private bool $welcomeEnabled;
    private string $welcomeMessage;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->setup();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        //$this->getLogger()->info("HideJoinMessage enabled.");
    }

    public function setup(): void {
        $this->reloadConfig();
        $cfg = $this->getConfig();

        $this->hideJoin = (bool) $cfg->get("hide-join-message", true);
        $this->hideLeave = (bool) $cfg->get("hide-leave-message", true);
        $this->customJoin = (string) $cfg->get("custom-join-message", "");
        $this->customLeave = (string) $cfg->get("custom-leave-message", "");
        $this->opException = (bool) $cfg->get("op-exception", false);

        $welcome = (array) $cfg->get("private-welcome", []);
        $this->welcomeEnabled = (bool) ($welcome["enabled"] ?? true);
        $this->welcomeMessage = (string) ($welcome["message"] ?? "§aWelcome, §e{player}§a!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() !== "hj") return false;

        if (!isset($args[0]) || strtolower($args[0]) !== "reload") {
            $sender->sendMessage("§eUsage: §f/hj reload");
            return true;
        }

        if (!$sender->hasPermission("hidejoinmessage.reload")) {
            $sender->sendMessage("§cNo permission.");
            return true;
        }

        $this->setup();
        $sender->sendMessage("§aConfig reloaded.");
        return true;
    }

    public function hideJoin(): bool {
        return $this->hideJoin;
    }
    public function hideLeave(): bool {
        return $this->hideLeave;
    }
    public function joinMsg(): string {
        return $this->customJoin;
    }
    public function leaveMsg(): string {
        return $this->customLeave;
    }
    public function opException(): bool {
        return $this->opException;
    }
    public function welcomeEnabled(): bool {
        return $this->welcomeEnabled;
    }
    public function welcomeMsg(): string {
        return $this->welcomeMessage;
    }
}
