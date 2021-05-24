<?php

namespace Porthd\Simpledataedit\Utilities;

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

use Exception;
use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
use Porthd\Simpledataedit\Exception\SimpledataeditException;

class ConfigurationUtility
{

    /**
     * @param array $listOfKeyAndClasses
     * @throws SimpledataeditException
     * @api
     */
    public static function addEditorClassesToSimpledateedit(array $listOfKeyAndClasses) {
        foreach ($listOfKeyAndClasses as $key => $className) {
            if ((!( $list = class_implements($className))) &&
                (!in_array(CustomEditorInterface::class,$list))
            ) {
                throw new SimpledataeditException(
                    'The array-entry for the editor-class `'.$key.'->'.$className.'` did not implement the interface ``'.
                    CustomEditorInterface::class .
                    ' Please check the ext_localconf.php of the CustomEditorInterface::class extension and/or the related class.',
                    1620579447,
                );
            }
        }
        self::mergeCustomGlobals(
            $listOfKeyAndClasses,
            SdeConst::SELF_NAME,
            SdeConst::SUBKEY_EDITOR
        );
    }

    /**
     * @param array $listOfExtsionnameAndYamlfiles
     * @throws SimpledataeditException
     * @api
     */
    public static function addYamlatorConfigsToSimpledateedit(array $listOfExtsionnameAndYamlfiles) {
        self::mergeCustomGlobals(
            $listOfExtsionnameAndYamlfiles,
            SdeConst::SELF_NAME,
            SdeConst::SUBKEY_YAMLATOR
        );
    }

    /**
     * Add your timer-classes to the list by using the unique index-name of your timer.
     * Your timer-class must implement interface Porthd\Timer\CustomTimer\TimerInterface
     * used in `ext_localconf.php`
     *
     * you can check this definition in TYPO3-Backend by the modul `configuration` from the TYPO3-core extention `lowlevel` (namespace: \TYPO3\CMS\Lowlevel)
     *
     * example for input:
     * $listOfCustomTimerClasses[YearlyTimer::timerIndexValue()] = DailyTimer::class;
     *
     * @param array $mapOfKeyAndClasses
     * @param string $extensionName
     * @param string $subkey
     * @throws SimpledataeditException
     */
    public static function mergeCustomGlobals(
        array $mapOfKeyAndClasses,
        $extensionName=SdeConst::SELF_NAME,
        $subkey = SdeConst::SUBKEY_EDITOR
    )
    {
        // add hooks for the datadigger to the configuration
        foreach ($mapOfKeyAndClasses as $key => $className) {
            self::expandNestedArray(
                $GLOBALS,
                ['TYPO3_CONF_VARS', 'EXTENSIONS', $extensionName, $subkey, $key],
                $className,
                true
            );
        }
    }

    /**
     * The method use a path to add into a nested array a new leaf or into an empty array, if the path is free.
     * Existing parts won't be overridden. Otherwise it flags a FALSE.
     *
     * similiar solution see the array-framework (https://github.com/minwork/array)
     *
     * @param mixed &$check
     * @param array $nestList
     * @param null $leaf
     * @return bool
     */
    public static function expandNestedArray(&$check, array $nestList, $leaf = null, $flagException = false)
    {
        $helper = &$check;  // the & is needed to get a point on a array getting by reference
        $flag = true;
        foreach ($nestList as $nestStage) {
            if (is_array($helper)) {
                if (!isset($helper[$nestStage])) {
                    $helper[$nestStage] = [];
                }
                $helper = &$helper[$nestStage];
            } else {
                $flag = false;
                break;
            }
        }
        if (($leaf !== null) && ($flag)) {
            if ((is_array($helper)) &&
                (empty($helper))
            ) {
                $helper = $leaf;
            } else if ($helper !== $leaf){
                $flag = false;
            }  // else entry is olready set - a double call happens for example in TYPO3 9.5 by the extensionmanger after activating an extension
        }
        if ((!$flag) && ($flagException)) {
            throw new SimpledataeditException(
                'The path `' . implode('/', $nestList) . '` will override information the assoziative array. '.
                'The original entry `' .                print_r($helper, true) . '` will be overridden by `'.
                print_r($leaf, true).'`. Perhaps some definitions in `ext_localconf.php`, `ext_tables.php` or in '.
                'an `[extension]/Configuration/Overrides/*.php` are wrong.',
                1601882833
            );
        }
        return $flag;
    }

}

