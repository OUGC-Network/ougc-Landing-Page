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

namespace ougc\LandingPage\Core;

use DateTime;
use PluginLibrary;
use PMDataHandler;

use function admin_redirect;
use function flash_message;
use function ougc\LandingPage\Admin\pluginInfo;

use const MYBB_ROOT;
use const PLUGINLIBRARY;

const URL = 'index.php?module=config-ougc_pages';

const DEBUG = false;

function addHooks(string $namespace)
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

function loadLanguage(): bool
{
    global $lang;

    if (!isset($lang->ougcLandingPage)) {
        $lang->load('ougcLandingPage');
    }

    return true;
}

function pluginLibraryRequirements(): object
{
    return (object)pluginInfo()['pl'];
}

function loadPluginLibrary(): bool
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

    return true;
}

function runHooks(string $hookName, &$pluginArguments = ''): bool
{
    global $plugins;

    if (!($plugins instanceof pluginSystem)) {
        return false;
    }

    $plugins->run_hooks('ougcLandingPage' . strtolower($hookName), $pluginArguments);

    return true;
}

function sanitizeIntegers(array $dataObject): array
{
    foreach ($dataObject as $objectKey => &$objectValue) {
        $objectValue = (int)$objectValue;
    }

    return array_filter($dataObject);
}

function url(string $newUrl = ''): string
{
    static $setUrl = URL;

    if (($newUrl = trim($newUrl))) {
        $setUrl = $newUrl;
    }

    return $setUrl;
}

function urlSet(string $newUrl)
{
    url($newUrl);
}

function urlGet(): string
{
    return url();
}

function urlBuild(array $urlAppend = [], bool $fetchImportUrl = false, bool $encode = true): string
{
    global $PL;

    if (!is_object($PL)) {
        $PL or require_once PLUGINLIBRARY;
    }

    if ($fetchImportUrl === false) {
        if ($urlAppend && !is_array($urlAppend)) {
            $urlAppend = explode('=', $urlAppend);
            $urlAppend = [$urlAppend[0] => $urlAppend[1]];
        }
    }/* else {
        $urlAppend = $this->fetch_input_url( $fetchImportUrl );
    }*/

    return $PL->url_append(urlGet(), $urlAppend, '&amp;', $encode);
}

function redirect(string $redirectMessage = '', bool $isError = false)
{
    if (defined('IN_ADMINCP')) {
        if ($redirectMessage) {
            flash_message($redirectMessage, ($isError ? 'error' : 'success'));
        }

        admin_redirect(urlBuild());
    } else {
        redirectBase(urlBuild(), $redirectMessage);
    }

    exit;
}

function redirectBase(string $url, string $message = '', string $title = '', bool $forceRedirect = false)
{
    \redirect($url, $message, $title, $forceRedirect);
}

function executeTask()
{
}

function getSetting(string $settingKey = '')
{
    global $mybb;

    return isset(SETTINGS[$settingKey]) ? SETTINGS[$settingKey] : (
    isset($mybb->settings['ougcLandingPage_' . $settingKey]) ? $mybb->settings['ougcLandingPage_' . $settingKey] : false
    );
}

function getTemplate(string $templateName = '', bool $enableHTMLComments = true): string
{
    global $templates;

    if (DEBUG) {
        $filePath = OUGCLANDINGPAGE_ROOT . "/templates/{$templateName}.html";

        $templateContents = file_get_contents($filePath);

        $templates->cache["ougcLandingPage_{$templateName}"] = $templateContents;
    }

    return $templates->render("ougcLandingPage_{$templateName}", true, $enableHTMLComments);
}