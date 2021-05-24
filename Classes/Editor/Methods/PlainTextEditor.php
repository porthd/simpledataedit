<?php

namespace Porthd\Simpledataedit\Editor\Methods;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3-Extension `simpledataedit`. It is a free software;
 *  you can redistribute it and/or modify
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
use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\EditorArgumentsInterface;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
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
    protected const NEEDED_ATTRIBUTES_EDIT = 'storagePid, fieldName, identField, identValue, storagePid, table'; // empty or comma-separated list of attributes, which are needed everytime by the editor
    protected const NEEDED_ATTRIBUTES_RESPONSE = 'storagePid, fieldName, identField, identValue, storagePid, table'; // empty or comma-separated list of attributes, which are needed everytime by the editor
    protected const OPTIONAL_ATTRIBUTES = ''; // empty or comma-separated list of attributes, which are needed sometimes by the editor or which contain in the yaml-file some default-values
    protected const YAML_PATH = 'EXP:simpledataedit/Configuration/Yaml/Editor/PlainTextEditor.yaml'; // empty. Ther are no default-values defined.


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
     * Comma-separated list of attributes, which are needed in every use-case.
     *
     * @return string
     */
    /**
     * @param string $type
     * @return string
     * @throws SimpledataeditException
     */
    public function getNeededAttributes(
        $type = CustomEditorInterface::TYPE_ATTRIBUTES_EDIT
    ): string    {
        switch($type) {
            case CustomEditorInterface::TYPE_ATTRIBUTES_EDIT :
                return self::NEEDED_ATTRIBUTES_EDIT;
                break;
            case CustomEditorInterface::TYPE_ATTRIBUTES_RESPONSE :
                return self::NEEDED_ATTRIBUTES_RESPONSE;
                break;
            default :
                throw new SimpledataeditException(
                    'The list for needed attribute for `'.$type.' ` is wrong. Please check your usage of '.
                    'the interface-function `getNeededAttributes` for the editor `'.self::SELF_NAME.'`. Allowed are only :'.
                    print_r(CustomEditorInterface::TYPE_ATTRIBUTES_LIST,true),
                    1621684362
                );
        }
    }

    /**
     * Comma-separated list of attributes, which are needed in some use-cases.
     *
     * @return string
     */
    public function getOptionalAttributes(
        $type = CustomEditorInterface::TYPE_ATTRIBUTES_EDIT
    ): string    {
        switch($type) {
            case CustomEditorInterface::TYPE_ATTRIBUTES_EDIT :
            case CustomEditorInterface::TYPE_ATTRIBUTES_RESPONSE :
                return self::OPTIONAL_ATTRIBUTES;
                break;
            default :
                throw new SimpledataeditException(
                    'The optional attribute-list for `'.$type.' ` is wrong defined. Please check your usage of '.
                    'the interface-function `getNeededAttributes` for the editor `'.self::SELF_NAME.'`. .Allowed are only :'.
                    print_r(CustomEditorInterface::TYPE_ATTRIBUTES_LIST,true),
                    1621684375
                );
        }

    }

    /**
     * path to default-values of some attribute, which are stored in a yaml-file for the editor.
     *
     * @return string
     */
    public function getDefaultYamlPath(): string
    {
        return self::YAML_PATH;
    }

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     * @param EditorArgumentsInterface $baseData
     * @param string|null $replaceData If the data is not equal to `null`, then the data will used in place of  content in $baseDate for the generation of the hash-value. (needed for Hash-Compare)     * @return string|false
     */
    public function generateHash(EditorArgumentsInterface $baseData,$replaceData=null)
    {
        $hashRaw = self::FIX_PRE . self::FIX_SPLIT . self::SELF_NAME;
        foreach ([
                     'getStoragePid',
                     'getTable',
                     'getIdentValue',
                     'getFieldName',
                     'getIdentField',
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
     * @param EditorArguments $editorArguments
     * @return string|false
     */
    public function getNameOfDataRequestMethod(EditorArguments $editorArguments)
    {
        return self::SELF_DATA_METHOD;
    }

    /**
     * @param EditorArguments $editorArguments
     * @return string|false
     */
    public function getNameOfDataUpdateMethod(EditorArguments $editorArguments)
    {
        return $this->getNameOfDataRequestMethod($editorArguments);
    }

    /**
     * used to parse Datas in the flow of update-proecess
     * GetData:     getDataFromDB => parseInPhp => parseInJavaScript => putInPlace
     * UpdateData:  GetDateFromContainer => parseInJavascript => parseInPhp => updateInDB
     *
     */

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function parseGetFlowJavaScript(EditorArguments $editorArguments): string
    {
        $name = self::whoAmI();
        $functionParameter = 'htmlToEdit';
        $functionBody = "return $functionParameter;";
        return "PorthdSimpledataedit.beforeSetting['$name'] = ($functionParameter) => {$functionBody};";
    }

    /**
     * no normalization needed i.e. for RTE-datas or something similiar
     *
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function parseRawInViewhelperPhp(EditorArguments $editorArguments): string
    {
        return $editorArguments->getRaw();
    }

    /**
     * normalize code in the middleware, before it will send to someting else
     * Perhaps you want to reanalyse some links, to rebuild a RTE-field
     * @param string $subject
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function parseUpdateFlowPhp(string $subject, EditorArguments $editorArguments): string
    {
        return strip_tags($subject);
    }

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     *
     * @param EditorArguments|null $editorArguments
     * @return string
     */
    public function parseJsFocusinContentToInnerHtml(?EditorArguments $editorArguments = null): string
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
     * return autonomous javascript-code for testing proposes
     *
     * @param EditorArguments|null $editorArguments
     * @return string
     */
    public function additionalJsTestingCode(?EditorArguments $editorArguments = null): string
    {
        return '';
    }

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     *
     * @param EditorArguments|null $editorArguments
     * @return string
     */
    public function parseJsFocusoutInnerHtmlToContent(?EditorArguments $editorArguments = null): string
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