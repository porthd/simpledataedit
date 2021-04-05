<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porthd <info@mobger.de>
 *
 *  All rights reserved
 *
 *  This script iSimpledataedits free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}


call_user_func(function () {

    // declare namespace in fluid-taemplates
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['simpledataedit'] = ['Porthd\\Simpledataedit\\ViewHelpers'];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        "@import 'EXT:simpledataedit/Configuration/TsConfig/Page/all.tsconfig'"
    );

    /**
     * define your own editor-class, if you have special elements
     */
    $whoAmI = 'whoAmI';  // if i use the name directly, PHPStorm remarks it with a warning ;-(
    $listOfCustomEditorClasses = [
        \Porthd\Simpledataedit\Editor\PlainTextEditor::$whoAmI() =>
            \Porthd\Simpledataedit\Editor\PlainTextEditor::class,
    ];
    \Porthd\Simpledataedit\Utilities\ConfigurationUtility::mergeCustomGlobals(
        $listOfCustomEditorClasses
    );
});
