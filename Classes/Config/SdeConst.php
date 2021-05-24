<?php

namespace Porthd\Simpledataedit\Config;

use PDO;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;

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


/**
 * Class for extension-wide constants. I dislike text in programm-code.
 *
 */
class SdeConst
{
    public const SELF_NAME = 'simpledataedit';
    public const PATH_FOR_UPDATE_MIDDLE = '/simpledataedit';
    public const YAML_MAIN_START = 'editor'; // empty. Ther are no default-values defined.

    public const SUBKEY_YAMLATOR = 'yamlator'; // Base Constant for correct Value
    public const SUBKEY_EDITOR = 'editor';
    public const DEFAULT_EDITOR = 'porthd-plaintext';

    public const MAP_DEFAULT_TYPE = PDO::PARAM_STR; // =2
    public const MAP_ALLOWED_TYPE = [
        PDO::PARAM_STR, // = 2
        PDO::PARAM_INT, // = 1
        PDO::PARAM_BOOL, // = 5
    ];

    public const TYPE_DATA_STRING = 'string';
    public const TYPE_DATA_INTEGER = 'integer';
    public const TYPE_DATA_FLOAT = 'float';
    public const TYPE_DATA_OBJECT = 'object';
    public const TYPE_DATA_MIXED = 'mixed';
    public const TYPE_DATA_LIST = [
        self::TYPE_DATA_STRING,
        self::TYPE_DATA_INTEGER,
        self::TYPE_DATA_FLOAT,
        self::TYPE_DATA_OBJECT,
        self::TYPE_DATA_MIXED,
    ];

    public const DONAME_EDIT_DATA = 'edit';
    public const DONAME_DELETE_CONTENT = 'deleteContent';
    public const DONAME_CREATE_CONTENT = 'makeContent';
    public const DONAME_DELETE_DATA = 'deleteData';
    public const DONAME_CREATE_DATA = 'makeData';
    public const DONAME_DELETE_CHILD = 'deleteChild';
    public const DONAME_CREATE_CHILD = 'makeChild';
    public const DONAME_DELETE_PROGENITOR = 'deleteProgenitor';
    public const DONAME_CREATE_PROGENITOR = 'makeProgenitor';
    public const DONAME_DELETE_PEER = 'deadPeer';
    public const DONAME_CREATE_PEER = 'makePeer';

    protected const DONNAME_ALLOWED_LIST = [
        self::DONAME_EDIT_DATA,
        self::DONAME_DELETE_CONTENT,
        self::DONAME_CREATE_CONTENT,
        self::DONAME_DELETE_DATA,
        self::DONAME_CREATE_DATA,
        self::DONAME_DELETE_CHILD,
        self::DONAME_CREATE_CHILD,
        self::DONAME_DELETE_PROGENITOR,
        self::DONAME_CREATE_PROGENITOR,
        self::DONAME_DELETE_PEER,
        self::DONAME_CREATE_PEER,
    ];

    public const KEY_STATIC_TEMP_JSDYNAMIC = 'editDynamicJs';
    public const KEY_STATIC_TEMP_JSLIB = 'editLibJs';
    public const KEY_STATIC_TEMP_CSS = 'editStyle';
    public const KEY_STATIC_EXTENSIONPATH = 'EXT:';

}
