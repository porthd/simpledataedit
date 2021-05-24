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

use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
use Porthd\Simpledataedit\Domain\Model\NeededTagArgs;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class CustomEditorInfoUtility
{

    /**
     * defines the EditorArguments-object for the used editor-class
     *
     * @return EditorArguments
     */
    public static function fillTagBuilderFromAttributeList(
        TagBuilder $tagBuilder,
        EditorArguments $customEditorInfo,
        NeededTagArgs $argsList,
        string $type = CustomEditorInterface::TYPE_ATTRIBUTES_EDIT
    ): void {
        $tagBuilder->addAttribute(
            NeededTagArgs::TAG_ATTR_DATA_PREFIX . NeededTagArgs::TAG_ATTR_DATA_EDITOR,
            $customEditorInfo->getEditor()
        );
        $tagBuilder->addAttribute(
            NeededTagArgs::TAG_ATTR_DATA_PREFIX . NeededTagArgs::TAG_ATTR_HASH_EDIT,
            $customEditorInfo->getHash()
        );

        $list = $argsList->getAttributeList($type);
        foreach ($list as $attribute) {
            $getter = 'get' . Ucfirst($attribute);
            $tagBuilder->addAttribute(
                'data-' . strtolower($attribute),
                $customEditorInfo->$getter()
            );
        }

    }

    /**
     * defines the EditorArguments-object for the used editor-class
     *
     * @return EditorArguments
     */
    public static function fillEditorArgumentsFromArgumentList(
        array $arguments,
        CustomEditorInterface $editor
    ): EditorArguments {
        $list = self::convertCommaListToList($editor, NeededTagArgs::PARAM_EDITOR_MUSTCOULD_EDIT);
        /** @var EditorArguments $editorArguments */
        $editorArguments = GeneralUtility::makeInstance(EditorArguments::class);
        foreach ($list as $attribute) {
            $setter = 'set' . Ucfirst($attribute);
            $editorArguments->$setter(
                $arguments['data-' . strtolower($attribute)]
            );
        }
        return $editorArguments;
    }

    /**
     * @param CustomEditorInterface $editor
     * @param array $addList
     * @return array
     */
    public static function convertCommaListToList(
        CustomEditorInterface $editor,
        array $addList = [],
        $type=CustomEditorInterface::TYPE_ATTRIBUTES_EDIT
    ): array    {
        /** @var string $commaList */
        $commaList = $editor::getNeededAttributes($type) . ',' . $editor::getOptionalAttributes($type);
        $list = array_unique(
            array_filter(
                array_map(
                    'trim',
                    explode(',', $commaList)
                )
            )
        );

        return array_merge(
            $addList,
            $list
        );
    }


}
