<?php

namespace Porthd\Simpledataedit\Services;

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

use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
use Porthd\Simpledataedit\Exception\SimpledataeditException;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ListOfEditorService allows the rendering and usage of different editor-classes
 */
class ListOfEditorService implements SingletonInterface
{

    private const MAIN_GLOBALS_PART = 'TYPO3_CONF_VARS';
    private const MAIN_GLOBALS_SUBPART = 'EXTENSIONS';


    // Hold the class instance.
    private $list = [];
    private $first;
    private $last;
    private $current;

    /**
     * instanciate all needed classes
     *
     * @return null
     */
    public function __construct()
    {
        $this->generateList(CustomEditorInterface::class, SdeConst::SELF_NAME, SdeConst::SUBKEY_EDITOR);
    }

    /**
     * @param string $selector
     * @param string $activeZoneName
     * @param array $params
     * @return CustomEditorInterface
     */
    public function getItemClass(string $selector): CustomEditorInterface
    {
        return $this->list[$selector]['instance'];
    }

    /**
     * @param string $selector
     * @param string $activeZoneName
     * @param array $params
     * @return CustomEditorInterface
     */
    public function getCurrentClass(): CustomEditorInterface
    {
        if ($this->current === null) {
            throw new SimpledataeditException(
                'There is no editorclass defined. The method `getCurrentClass` should newer be called in this place.',
                1617473294
            );
        }
        return $this->current['instance'];
    }

    /**
     * @param string $selector
     * @param string $activeZoneName
     * @param array $params
     * @return CustomEditorInterface
     */
    public function getCurrentName(): string
    {
        if ($this->current === null) {
            throw new SimpledataeditException(
                'There is no editorclass defined. The method `getCurrentName` should newer be called in this place.',
                1617513299
            );
        }
        return $this->current['selfName'];
    }

    // init a double-chained list for iteration
    public function goFirst(): bool
    {
        if ($this->first !== null) {
            $this->current = $this->first;
            return true;
        }
        return false;
    }

    public function goLast(): bool
    {
        if ($this->last !== null) {
            $this->current = $this->last;
            return true;
        }
        return false;
    }

    public function goNext(): bool
    {
        if ($this->current === $this->last) {
            return false;
        }
        $this->current = $this->current['next'];
        return true;
    }

    public function goPrev(): bool
    {
        if ($this->current === $this->first) {
            return false;
        }
        $this->current = $this->current['prev'];
        return true;
    }


    /**
     * @param string $selector
     * @param string $activeZoneName
     * @param array $params
     * @return CustomEditorInterface
     */
    public function getFirstItemClass(string $selector): CustomEditorInterface
    {
        return $this->list[$selector];
    }

    /**
     * @param string $interfaceCheckName
     * @param string $extensionName
     * @param string $subkey
     */
    private function generateList(
        $interfaceCheckName = CustomEditorInterface::class,
        $extensionName = SdeConst::SELF_NAME,
        $subkey = SdeConst::SUBKEY_EDITOR
    ): void {

        $this->list = [];
        // Call post-processing function for constructor:
        if ((is_array($GLOBALS[self::MAIN_GLOBALS_PART][self::MAIN_GLOBALS_SUBPART][$extensionName][$subkey])) &&
            (
                count(
                    ($classList = $GLOBALS[self::MAIN_GLOBALS_PART][self::MAIN_GLOBALS_SUBPART][$extensionName][$subkey])
                ) > 0
            )
        ) {
            $flagFirst = true;
            $this->last = null;
            $this->first = null;
            $this->current = null;
            $selfName = '';
            foreach ($classList as $className) {
                $classInterface = class_implements($className);
                if (in_array($interfaceCheckName, $classInterface)) {
                    $classObject = GeneralUtility::makeInstance($className);
                    $selfName = $classObject::whoAmI();
                    $this->list[$selfName]['instance'] = $classObject;
                    $this->list[$selfName]['selfName'] = $selfName;  // The key of this element is not Part of the Point
                    $this->list[$selfName]['prev'] = null;  // generate this part of object, because the generation via reference seems not to work
                    $this->list[$selfName]['next'] = null;  // generate this part of object, because the generation via reference seems not to work
                    if ($flagFirst) {
                        $this->first = &$this->list[$selfName];
                        $this->current = $this->first;
                        $this->last = $this->first;
                        $flagFirst = false;
                    } else {
                        $oldSelfName = $this->current['selfName'];
                        $this->list[$oldSelfName]['next'] = &$this->list[$selfName];
                        $this->list[$selfName]['prev'] = &$this->list[$oldSelfName];
                        $this->last = &$this->list[$selfName];
                        $this->current = $this->last;
                    }
                }
            }
        }
    }
}
