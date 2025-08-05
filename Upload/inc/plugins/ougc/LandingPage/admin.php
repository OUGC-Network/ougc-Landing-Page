<?php

/***************************************************************************
 *
 *    OUGC Landing Page plugin (/inc/plugins/ougcLandingPage/admin.php)
 *    Author: Omar Gonzalez
 *    Copyright: © 2021 Omar Gonzalez
 *
 *    Website: https://ougc.network
 *
 *    Set a forced landing page for certain groups.
 *
 ***************************************************************************
 ****************************************************************************
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ****************************************************************************/

declare(strict_types=1);

namespace ougc\LandingPage\Admin;

use stdClass;
use PluginLibrary;

use function ougc\LandingPage\Core\loadLanguage;

function pluginInfo(): array
{
    global $lang;

    loadLanguage();

    return [
        'name' => 'OUGC Landing Page',
        'description' => $lang->setting_group_ougcLandingPage_desc,
        'website' => 'https://ougc.network',
        'author' => 'Omar G.',
        'authorsite' => 'https://ougc.network',
        'version' => '1.8.0',
        'versioncode' => 1800,
        'compatibility' => '18*',
        'codename' => 'ougcLandingPage',
        'pl' => [
            'version' => 13,
            'url' => 'https://community.mybb.com/mods.php?action=view&pid=573'
        ]
    ];
}

function pluginActivate(): void
{
    global $PL, $cache, $lang;

    loadLanguage();

    $pluginInfo = pluginInfo();

    loadPluginLibrary();

    // Add settings group
    $settingsContents = file_get_contents(OUGCLANDINGPAGE_ROOT . '/settings.json');

    $settingsData = json_decode($settingsContents, true);

    foreach ($settingsData as $settingKey => &$settingData) {
        if (empty($lang->{"setting_ougcLandingPage_{$settingKey}"})) {
            continue;
        }

        if ($settingData['optionscode'] == 'select') {
            foreach ($settingData['options'] as $optionKey) {
                $settingData['optionscode'] .= "\n{$optionKey}={$lang->{"setting_ougcLandingPage_{$settingKey}_{$optionKey}"}}";
            }
        }

        $settingData['title'] = $lang->{"setting_ougcLandingPage_{$settingKey}"};
        $settingData['description'] = $lang->{"setting_ougcLandingPage_{$settingKey}_desc"};
    }

    $PL->settings(
        'ougcLandingPage',
        $lang->setting_group_ougcLandingPage,
        $lang->setting_group_ougcLandingPage_desc,
        $settingsData
    );

    // Insert/update version into cache
    $plugins = $cache->read('ougc_plugins');

    if (!$plugins) {
        $plugins = [];
    }

    if (!isset($plugins['LandingPage'])) {
        $plugins['LandingPage'] = $pluginInfo['versioncode'];
    }

    /*~*~* RUN UPDATES START *~*~*/

    /*~*~* RUN UPDATES END *~*~*/

    $plugins['LandingPage'] = $pluginInfo['versioncode'];

    $cache->update('ougc_plugins', $plugins);
}

function pluginIsInstalled(): bool
{
    global $cache;

    $plugins = (array)$cache->read('ougc_plugins');

    return isset($plugins['LandingPage']);
}

function pluginUninstall(): void
{
    global $PL, $cache;

    loadPluginLibrary();

    $PL->settings_delete('ougcLandingPage');

    // Delete version from cache
    $plugins = (array)$cache->read('ougc_plugins');

    if (isset($plugins['LandingPage'])) {
        unset($plugins['LandingPage']);
    }

    if (!empty($plugins)) {
        $cache->update('ougc_plugins', $plugins);
    } else {
        $cache->delete('ougc_plugins');
    }
}

function pluginLibraryRequirements(): stdClass
{
    return (object)pluginInfo()['pl'];
}

function loadPluginLibrary(): void
{
    global $PL, $lang;

    loadLanguage();

    $fileExists = file_exists(PLUGINLIBRARY);

    if ($fileExists && !($PL instanceof PluginLibrary)) {
        require_once PLUGINLIBRARY;
    }

    if (!$fileExists || $PL->version < pluginLibraryRequirements()->version) {
        flash_message(
            $lang->sprintf(
                $lang->ougcLandingPagePluginLibrary,
                pluginLibraryRequirements()->url,
                pluginLibraryRequirements()->version
            ),
            'error'
        );

        admin_redirect('index.php?module=config-plugins');
    }
}