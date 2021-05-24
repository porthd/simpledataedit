<?php

namespace Porthd\Simpledataedit\Domain\Model;

use func;
use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
use Porthd\Simpledataedit\Exception\SimpledataeditException;

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
class NeededTagArgs
{


    public const CHECK_USERROLE_FOR_STORAGE_PID = 'storagePid';

    public const TAG_ATTR_DATA_PREFIX = 'data-';

    public const TAG_ATTR_JSON_DATA = 'jsonData';
    public const TAG_ATTR_YAML_DATA = 'yamlDataPath';

    public const TAG_ATTR_FLUID_DATA = 'fluidData';
    public const TAG_ATTR_DATA_EDITOR = 'editor';
    public const TAG_ATTR_HASH_EDIT = 'hash';
    public const TAG_ATTR_HASH_ATTRIBUTES = 'attributesHash';
    public const TAG_ATTR_DEBUG = 'flagDebug';
    public const TAG_ATTR_JSONRAWCONTENT = 'jsonRawContent';

    protected const PARAM_EDITOR_MUST_EDIT = [
        self::TAG_ATTR_DATA_EDITOR,
        self::TAG_ATTR_HASH_EDIT,
    ];
    protected const PARAM_EDITOR_COULD_EDIT = [
        self::TAG_ATTR_JSON_DATA,
        self::TAG_ATTR_YAML_DATA,
        self::TAG_ATTR_FLUID_DATA,
        self::TAG_ATTR_HASH_ATTRIBUTES,
        self::TAG_ATTR_DEBUG,
        self::TAG_ATTR_JSONRAWCONTENT,
    ];

    protected const PARAM_EDITOR_MUST_RESPONSE = [
        self::TAG_ATTR_DATA_EDITOR,
        self::TAG_ATTR_DEBUG,
        self::TAG_ATTR_HASH_EDIT,
        self::TAG_ATTR_HASH_ATTRIBUTES,

    ];
    protected const PARAM_EDITOR_COULD_RESPONSE = [
        self::TAG_ATTR_JSONRAWCONTENT,
    ];

    public const PARAM_EDITOR_MUSTCOULD_EDIT = [
        ...self::PARAM_EDITOR_MUST_EDIT,
        ...self::PARAM_EDITOR_COULD_EDIT,
    ];

    public const PARAM_EDITOR_MUSTCOULD_RESPONSE = [
        ...self::PARAM_EDITOR_MUST_RESPONSE,
        ...self::PARAM_EDITOR_COULD_RESPONSE,
    ];


    public $editor;
    public $must = [
        CustomEditorInterface::TYPE_ATTRIBUTES_EDIT => [],
        CustomEditorInterface::TYPE_ATTRIBUTES_RESPONSE => [],
    ];
    public $could = [
        CustomEditorInterface::TYPE_ATTRIBUTES_EDIT => [],
        CustomEditorInterface::TYPE_ATTRIBUTES_RESPONSE => [],
    ];
    public $needed = [
        CustomEditorInterface::TYPE_ATTRIBUTES_EDIT => [],
        CustomEditorInterface::TYPE_ATTRIBUTES_RESPONSE => [],
    ];
    public $optional = [
        CustomEditorInterface::TYPE_ATTRIBUTES_EDIT => [],
        CustomEditorInterface::TYPE_ATTRIBUTES_RESPONSE => [],
    ];

    /**
     * @param CustomEditorInterface $editor
     */
    public function __construct(?CustomEditorInterface $editor = null)
    {
        if ($editor !== null) {
            foreach (CustomEditorInterface::TYPE_ATTRIBUTES_LIST as $type) {
                $this->needed[$type] = $editor->getNeededAttributes($type);
                $this->optional[$type] = $editor->getOptionalAttributes($type);
            }
        }
    }


    /**
     * @param CustomEditorInterface $editor
     */
    public function setEditor(CustomEditorInterface $editor)
    {
        foreach (CustomEditorInterface::TYPE_ATTRIBUTES_LIST as $type) {
            $this->needed[$type] = $editor->getNeededAttributes($type);
            $this->optional[$type] = $editor->getOptionalAttributes($type);
        }
    }

    public function getAttributeList($type = CustomEditorInterface::TYPE_ATTRIBUTES_EDIT)
    {
        if (!in_array($type, CustomEditorInterface::TYPE_ATTRIBUTES_LIST)) {
            throw new SimpledataeditException(
                'The Type `' . $type . '` has an unallowed value. Allowed are the followings: `' .
                implode('`,`', CustomEditorInterface::TYPE_ATTRIBUTES_LIST) . '`.',
                1621687163
            );
        }
        return array_filter(
            array_unique(
                array_merge(
                    $this->must[$type],
                    $this->needed[$type],
                    $this->could[$type],
                    $this->optional[$type]
                )
            )
        );
    }
}