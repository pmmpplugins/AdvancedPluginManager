<?php


namespace pmmpplugins\advancedpluginmanager\api;

use pmmpplugins\advancedpluginmanager\AdvancedPluginManager;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

/**
 * Author: pmmp-plugins
 * Project: AdvancedPluginManager
 * File: API.php
 * Date: 16.12.18
 * IDE: PhpStorm
 */
class API
{
    public static function enable(AdvancedPluginManager $advancedPluginManager, string $requestedPlugin): bool
    {
        $plugin = $advancedPluginManager->getServer()->getPluginManager()->getPlugin($requestedPlugin);
        $pluginManager = $advancedPluginManager->getServer()->getPluginManager();

        if ($plugin !== null) {
            $pluginManager->enablePlugin($plugin);
            return true;
        } else {
            return false;
        }
    }

    public static function disable(AdvancedPluginManager $advancedPluginManager, string $requestedPlugin): bool
    {
        $plugin = $advancedPluginManager->getServer()->getPluginManager()->getPlugin($requestedPlugin);
        $pluginManager = $advancedPluginManager->getServer()->getPluginManager();

        if ($plugin !== null) {
            $pluginManager->disablePlugin($plugin);
            return true;
        } else {
            return false;
        }
    }

    public static function filterPlugin(Plugin $plugin, Config $config, int $type): bool
    {
        if ($type === 0) {
            $enabledPlugins = $config->get("enabled");

            for ($i = 0; $i < count($enabledPlugins); $i++) {
                if ("*" === $enabledPlugins[$i]) {
                    return true;
                } elseif ($plugin->getName() === $enabledPlugins[$i]) {
                    return true;
                } else {
                    return false;

                }
            }
        } elseif ($type === 1) {
            $disabledPlugins = $config->get("disabled");

            for ($i = 0; $i < count($disabledPlugins); $i++) {
                if ("*" === $disabledPlugins[$i]) {
                    return true;
                } elseif ($plugin->getName() === $disabledPlugins[$i]) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public static function filterPluginsStartup(AdvancedPluginManager $advancedPluginManager): void
    {
        $plugins = $advancedPluginManager->getServer()->getPluginManager()->getPlugins();

        foreach ($plugins as $plugin) {

            // Enabled plugins
            if (API::filterPlugin($plugin, $advancedPluginManager->getPluginList(), 0)) {
                $advancedPluginManager->getServer()->getPluginManager()->enablePlugin($plugin);
                $advancedPluginManager->getLogger()->info("Enabled plugin '" . $plugin->getName() . "'");
            }

            // Disabled plugins
            if (API::filterPlugin($plugin, $advancedPluginManager->getPluginList(), 1)) {
                $advancedPluginManager->getServer()->getPluginManager()->disablePlugin($plugin);
                $advancedPluginManager->getLogger()->info("Disabled plugin '" . $plugin->getName() . "'");
            }
        }
    }
}