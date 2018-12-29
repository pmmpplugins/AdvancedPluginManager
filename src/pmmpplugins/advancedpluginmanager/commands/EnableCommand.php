<?php


namespace pmmpplugins\advancedpluginmanager\commands;

use pmmpplugins\advancedpluginmanager\api\API;
use pmmpplugins\advancedpluginmanager\AdvancedPluginManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

/**
 * Author: pmmp-plugins
 * Project: AdvancedPluginManager
 * File: EnableCommand.php
 * Date: 16.12.18
 * IDE: PhpStorm
 */
class EnableCommand extends Command implements PluginIdentifiableCommand
{
    private $advancedPluginManager;
    private $prefix;

    public function __construct(AdvancedPluginManager $advancedPluginManager)
    {
        $this->advancedPluginManager = $advancedPluginManager;
        $this->prefix = $advancedPluginManager->getPrefix();

        parent::__construct("enable", "Enable a (disabled) plugin.", "/enable <plugin>", []);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if ($sender->hasPermission("advancedpluginmanager.enable")) {
            if (isset($args[0])) {
                if (API::enable($this->advancedPluginManager, $args[0])){
                    $sender->sendMessage($this->prefix . "Enabled plugin '" . $args[0] . "'.");
                } else {
                    $sender->sendMessage($this->prefix . "'" . $args[0] . "' is not a valid plugin.");
                }
            } else {
                $sender->sendMessage($this->prefix . "/enable <plugin>");
            }
            return true;
        } else {
            $sender->sendMessage($this->prefix . "You have no permission to perform this command!");
            return false;
        }
    }

    public function getPlugin(): Plugin
    {
        return $this->pluginManager;
    }
}