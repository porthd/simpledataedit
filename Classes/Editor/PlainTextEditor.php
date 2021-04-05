<?php

namespace Porthd\Simpledataedit\Editor;

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

use Exception;
use Porthd\Simpledataedit\Exception\SimpledataeditException;

/**
 * A realistion of the ditor-class, which allows the editing in the frontend.
 * The interface define the methods, which are needed for an update single datefield by this extension.
 *
 */
class PlainTextEditor implements CustomEditorInterface
{

    protected const SELF_NAME =  'porthd-plaintext';
    protected const FIX_PRE = 'Begin';
    protected const FIX_SPLIT = '#';
    protected const FIX_POST = '#End';

    protected const SELF_DATA_METHOD = false; // false or the name of method defined in this class

    /**
     * A object should have some selfawareness. So i can be recognized in the bunch.
     * I recommend to use the structure `vendor-description`
     *
     * @return string
     */
    public static function whoAmI(): string
    {
        return self::SELF_NAME;
    }

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     * @param CustomEditorInfoInterface $baseData
     * @param string|null $replaceData If the data is not equal to `null`, then the data will used in place of  content in $baseDate for the generation of the hash-value. (needed for Hash-Compare)     * @return string|false
     */
    public function generateHash(CustomEditorInfoInterface $baseData,$replaceData=null)
    {
        $hashRaw = self::FIX_PRE . self::FIX_SPLIT . self::SELF_NAME;
        foreach ([
                     'getPid',
                     'getTable',
                     'getUid',
                     'getFieldname',
                     'getIdentname',
                     'getParams',
                 ] as $funcName) {
            $hashRaw .= self::FIX_SPLIT . $baseData->$funcName();
        }
        if ($replaceData === null) {
            $hashRaw .= self::FIX_SPLIT . $baseData->getRaw();
        } else {
            try {
            $hashRaw .= self::FIX_SPLIT . $replaceData;
            } catch (Exception $e) {
                throw new SimpledataeditException(
                    'The replacedatacould not converted to a string.'."\n".print_r($replaceData,true) .
                    'Check the programming of the editor, which reference is definded in here: ' . print_r($baseData,true),
                    1617564660
                );

            }
        }
        $hashRaw .= self::FIX_SPLIT . self::FIX_POST;
        return md5($hashRaw);
    }



    /**
     * used only in Middleware for alternative datarequest
     *
     */

    /**
     * if it return the name of a editord method to retrieve datas from anyware.
     * It will override the standardmethod of simpledataedit
     *
     * @param CustomEditorInfo $customParameter
     * @return string|false
     */
    public function getNameOfDataRequestMethod(CustomEditorInfo $customParameter)
    {
        return self::SELF_DATA_METHOD;
    }

    /**
     * @param CustomEditorInfo $customParameter
     * @return string|false
     */
    public function getNameOfDataUpdateMethod(CustomEditorInfo $customParameter)
    {
        return self::SELF_DATA_METHOD;
    }

    /**
     * used to parse Datas in the flow of update-proecess
     * GetData:     getDataFromDB => parseInPhp => parseInJavaScript => putInPlace
     * UpdateData:  GetDateFromContainer => parseInJavascript => parseInPhp => updateInDB
     *
     */

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     * @param CustomEditorInfo $customParameter
     * @return string
     */
    public function parseGetFlowJavaScript(CustomEditorInfo $customParameter): string
    {
        $name = $this->whoAmI();
        $functionParameter = 'htmlToEdit';
        $functionBody = "return $functionParameter;";
        return "PorthdSimpledataedit.beforeSetting['$name'] = ($functionParameter) => {$functionBody};";
    }

    /**
     * no normalization needed
     *
     * @param CustomEditorInfo $customParameter
     * @return string
     */
    public function parseRawInViewhelperPhp(CustomEditorInfo $customParameter): string
    {
        return $customParameter->getRaw();
    }

    /**
     * normalize code in the middleware, before it will send to someting else
     * Perhaps you want to reanalyse some links, to rebuild a RTE-field
     * @param string $subject
     * @param CustomEditorInfo $customParameter
     * @return string
     */
    public function parseUpdateFlowPhp(string $subject, CustomEditorInfo $customParameter): string
    {
        return strip_tags($subject);
    }

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     * @param CustomEditorInfo $customParameter
     * @return string
     */
    public function parseJsFocusinContentToInnerHtml(): string
    {
        return '';
        // example The function will be part of an object and get the node as a parameter
        // Make schure, to en with an comma (,)
        // A Copy of the content will an JSON-encoded string in data-content
        //        return $javascriptInline = $this->whoAmI().': function(node) {
        //            node.innerHTML = JSON.parse(node.dataset.content);
        //        },';
    }
    /**
     * return inline-javascript-Code, which is used by the viewhelper
     *
     * @return string
     */
    public function parseJsFocusoutInnerHtmlToContent(): string
    {
        return '';
        // example The function will be part of an object and get the node as a parameter
        // Make schure, to en with an comma (,)
        // A Copy of the content will an JSON-encoded string in data-content
        //        return $javascriptInline = $this->whoAmI().': function(node) {
        //            node.dataset.content = JSON.stringify(node.innerHTML);
        //        },';
    }

}