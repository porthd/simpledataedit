<?php

namespace Porthd\Simpledataedit\Config;

use PDO;
use Porthd\Simpledataedit\Editor\CustomEditorInterface;

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


/**
 * Class for extension-wide constants. I dislike text in programm-code.
 *
 */
class SdeConst
{
    public const SELF_NAME = 'simpledataedit';
    public const PATH_FOR_UPDATE_MIDDLE = '/simpledataedit';

    public const SUBKEY_EDITOR = 'editor';
    public const DEFAULT_EDITOR = 'porthd-plaintext';

    public const MAP_DEFAULT_TYPE = PDO::PARAM_STR; // =2
    public const MAP_ALLOWED_TYPE = [
        PDO::PARAM_STR, // = 2
        PDO::PARAM_INT, // = 1
        PDO::PARAM_BOOL, // = 5
    ];

    public const KEY_STATIC_TEMP_JSDYNAMIC = 'editDynamicJs';
    public const KEY_STATIC_TEMP_JSLIB = 'editLibJs';
    public const KEY_STATIC_TEMP_CSS = 'editStyle';
    public const KEY_STATIC_EXTENSIONPATH = 'EXT:';

}
