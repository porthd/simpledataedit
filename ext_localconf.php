<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de>
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

    /**
     * define your own editor-class, if you have special elements
     */
    $whoAmI = 'whoAmI';  // if i use the name directly, PHPStorm remarks it with a warning ;-(
    $listOfCustomEditorClasses = [
        \Porthd\Simpledataedit\Editor\Methods\PlainTextEditor::$whoAmI() =>
            \Porthd\Simpledataedit\Editor\Methods\PlainTextEditor::class,
    ];
    \Porthd\Simpledataedit\Utilities\ConfigurationUtility::mergeCustomGlobals(
        $listOfCustomEditorClasses
    );

    /** Cache-registration - use VariableFrontend in the Frontend */
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['simpledataedit_configsave'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['simpledataedit_configsave'] = [];
    }

});
