<?php

namespace Porthd\Simpledataedit\Utilities;

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

use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Editor\CustomEditorInfo;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CustomEditorInfoUtility
{


    /**
     * defines the CustomEditorInfo-object for the used editor-class
     *
     * @return CustomEditorInfo
     */
    public static function prepareCustomEditorInfoFromArgumentList(array $arguments): CustomEditorInfo
    {
        $customEditorInfo = GeneralUtility::makeInstance(CustomEditorInfo::class);
        // editor -required
        $editorName = $arguments['editor'];
        $customEditorInfo->setEditor($editorName);
        // pid - required for access-check
        $pid = $arguments['pid'];
        $customEditorInfo->setPid($pid);

        // columnname of datas in the requested table
        // fieldname - required
        $fieldname = $arguments['fieldname'];
        $customEditorInfo->setFieldname($fieldname);

        // uid - required integer-value of the datarow (if a
        $uid = $arguments['uid'];
        $customEditorInfo->setUid($uid);
        // type- default = 2 => type of data is string (allowed boolean and integer)
        if (isset($arguments['type'])) {
            $type = $arguments['type'];
            $type = (in_array($type, SdeConst::MAP_ALLOWED_TYPE) ?
                $type :
                SdeConst::MAP_DEFAULT_TYPE
            );
            $customEditorInfo->setType($type);
        } // default is SdeConst::MAP_DEFAULT_TYPE

        // table - default tt_content (with respect to the extension `mask`&`mask_export` and the new `wave` of content-elements
        if (isset($arguments['table'])) {
            $table = $arguments['table'];
            $customEditorInfo->setTable($table); // default is tt_content
        } // default is 'tt_content'

        // identname - default 'uid'
        if (isset($arguments['identname'])) {
            $identname = $arguments['identname'];
            $customEditorInfo->setIdentname($identname);
        } // default is 'uid');

        // Params - default JSON- empty array '[]'
        if (isset($arguments['paramList'])) {
            $paramsJson = json_encode($arguments['paramList']);
            $customEditorInfo->setParams($paramsJson);
        }

        return $customEditorInfo;
    }

}
