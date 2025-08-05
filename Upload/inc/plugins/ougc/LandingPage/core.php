<?php

/***************************************************************************
 *
 *    OUGC Landing Page plugin (/inc/plugins/ougcLandingPage/core.php)
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

namespace ougc\LandingPage\Core;

function addHooks(string $namespace): void
{
    global $plugins;

    $namespaceLowercase = strtolower($namespace);

    $definedUserFunctions = get_defined_functions()['user'];

    foreach ($definedUserFunctions as $callable) {
        $namespaceWithPrefixLength = strlen($namespaceLowercase) + 1;

        if (substr($callable, 0, $namespaceWithPrefixLength) == $namespaceLowercase . '\\') {
            $hookName = substr_replace($callable, '', 0, $namespaceWithPrefixLength);

            $priority = substr($callable, -2);

            if (is_numeric(substr($hookName, -2))) {
                $hookName = substr($hookName, 0, -2);
            } else {
                $priority = 10;
            }

            $plugins->add_hook($hookName, $callable, $priority);
        }
    }
}

function loadLanguage(): void
{
    global $lang;

    if (!isset($lang->ougcLandingPage)) {
        $lang->load('ougcLandingPage');
    }
}

function redirect(string $url, int $response_code = 0): void
{
    global $mybb;

    $url = htmlspecialchars_decode($url);

    $url = str_replace(array("\n", "\r", ';'), '', $url);

    run_shutdown();

    if (!my_validate_url($url, true, true)) {
        header("Location: {$mybb->settings['bburl']}/{$url}", false, $response_code);
    } else {
        header("Location: {$url}", false, $response_code);
    }
}

function getSetting(string $settingKey = '')
{
    global $mybb;

    return SETTINGS[$settingKey] ?? (
        $mybb->settings['ougcLandingPage_' . $settingKey] ?? false
    );
}