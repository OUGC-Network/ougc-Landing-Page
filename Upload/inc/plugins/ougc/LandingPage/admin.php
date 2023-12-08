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
 * This program is protected software: you can make use of it under
 * the terms of the OUGC Network EULA as detailed by the included
 * "EULA.TXT" file.
 *
 * This program is distributed with the expectation that it will be
 * useful, but WITH LIMITED WARRANTY; with a limited warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * OUGC Network EULA included in the "EULA.TXT" file for more details.
 *
 * You should have received a copy of the OUGC Network EULA along with
 * the package which includes this file.  If not, see
 * <https://ougc.network/eula.txt>.
 ****************************************************************************/

declare(strict_types=1);

namespace ougc\LandingPage\Admin;

use DirectoryIterator;

use MybbStuff_MyAlerts_AlertTypeManager;

use MybbStuff_MyAlerts_Entity_AlertType;

use function file_get_contents;
use function json_decode;
use function ougc\LandingPage\Core\loadLanguage;

use function ougc\LandingPage\Core\loadPluginLibrary;

use const MYBB_ROOT;

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

function pluginActivate()
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

function pluginDeactivate()
{
}

function pluginInstall()
{
}

function pluginIsInstalled(): bool
{
    global $cache;

    $plugins = (array)$cache->read('ougc_plugins');

    return isset($plugins['LandingPage']);
}

function pluginUninstall()
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