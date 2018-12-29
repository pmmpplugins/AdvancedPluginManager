<?php

namespace pmmpplugins\advancedpluginmanager;

use pmmpplugins\advancedpluginmanager\commands\DisableCommand;
use pmmpplugins\advancedpluginmanager\commands\EnableCommand;
use pmmpplugins\advancedpluginmanager\tasks\DelayedPluginCheckTask;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

/**
 * Author: pmmp-plugins
 * Project: AdvancedPluginManager
 * File: AdvancedPluginManagernManager.php
 * Date: 16.12.18
 * IDE: PhpStorm
 */
class AdvancedPluginManager extends PluginBase
{
    private $prefix;
    private $pluginList;

    public function onEnable()
    {
        $this->prefix = TextFormat::GRAY . "[" . TextFormat::GREEN . "AdvancedPluginManager" . TextFormat::GRAY . "] " . TextFormat::RESET;

        $this->loadCommands();
        $this->loadFiles();
        $this->loadTasks();

        $this->getLogger()->info("Enabled AdvancedPluginManager v" . $this->getDescription()->getVersion() . " made by PMMP-Plugins");
    }

    public function onDisable()
    {
        $this->getLogger()->info("Disabled AdvancedPluginManager v" . $this->getDescription()->getVersion() . " made by PMMP-Plugins");
    }



    private function loadCommands(): void
    {
        $commandMap = $this->getServer()->getCommandMap();

        $commandMap->register("advancedpluginmanager", new EnableCommand($this));
        $commandMap->register("advancedpluginmanager", new DisableCommand($this));
    }

    private function loadFiles(): void
    {
        @mkdir($this->getDataFolder());
        $this->saveResource("pluginList.yml");
        $this->pluginList = new Config($this->getDataFolder() . "pluginList.yml");
    }

    private function loadTasks(): void
    {
        $scheduler = $this->getScheduler();

        $scheduler->scheduleDelayedTask(new DelayedPluginCheckTask($this), $this->getPluginList()->get("execution-delay") * 10);
    }



    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getPluginList(): Config
    {
        return $this->pluginList;
    }
}