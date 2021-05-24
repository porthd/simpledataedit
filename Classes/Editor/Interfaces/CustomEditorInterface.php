<?php

namespace Porthd\Simpledataedit\Editor\Interfaces;

use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\EditorArgumentsInterface;


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
 * Use of classes for more flexibility in the case of frontend-editing.
 * The interface define the methods, which are needed for an update single datefield by this extension.
 *
 */
interface CustomEditorInterface
{
    public const TYPE_ATTRIBUTES_EDIT = 'edit';
    public const TYPE_ATTRIBUTES_RESPONSE = 'response';
    public const TYPE_ATTRIBUTES_LIST = [
        self::TYPE_ATTRIBUTES_EDIT,
        self::TYPE_ATTRIBUTES_RESPONSE,
    ];

    /**
     * A object should have some selfawareness. So i can be recognized in the bunch.
     *
     * @return string
     */
    public static function whoAmI(): string;

    /**
     * A object should have some self-awareness about its in every cases needed parameter.
     * The comma-separated list can contain only attributes from the class EditorArguments,
     * which itself implements the EditorArgumentsInterface via a list of traits.
     *
     * @param string $type Type is one of the constants in self::TYPE_ATTRIBUTES_LIST
     * @return string
     */
    public function getNeededAttributes(string $type = self::TYPE_ATTRIBUTES_EDIT): string;

    /**
     * A object should have some self-awareness about its optional parameter, which are only needed in some use-cases.
     * The comma-separated list con only contain attribute from the class EditorArguments,
     * which itself implements the EditorArgumentsInterface via a list of traits.
     *
     * @param string $type Type is one of the constants in self::TYPE_ATTRIBUTES_LIST
     * @return string
     */
    public function getOptionalAttributes(string $type = self::TYPE_ATTRIBUTES_EDIT): string;

    /**
     * A editor can contain a custom yaml-file, with an predefined set of (default-)attributes.
     * The yaml-file is helpful, to declare more attributes as optional.
     *
     * The method delivers an empty string or the path to a yaml-file, which contains the default-values of some attribute for the editor.
     *
     * @return string
     */
    public function getDefaultYamlPath(): string;

    /**
     * @param EditorArgumentsInterface $baseData
     * @param string|null $replaceData If the data is not equal to `null`, then the data will used in place of  content in $baseDate for the generation of the hash-value. (needed for Hash-Compare)
     * @return string|false
     */
    public function generateHash(EditorArgumentsInterface $baseData, $replaceData = null);

    /**
     * the raw-content is contains in Getter/Setter-Class in (protected) $editorArguments->raw
     * normalize code in the middleware, before it will rendered in the template
     *
     * remark: Perhaps you want to convert a unixttimestamp to an regular date, because that is easier in JavaScript
     * to handle or you wannt to convert some links in an RTE-Editing
     *
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function parseRawInViewhelperPhp(EditorArguments $editorArguments): string;

    /**
     * normalize code in the middleware, before it will send to something else
     * Perhaps you want to reanalyse some links, to rebuild a RTE-field
     *
     * @param string $subject
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function parseUpdateFlowPhp(string $subject, EditorArguments $editorArguments): string;


    /**
     * ***************************************************
     * own javascript-method to normalize rendered datas
     * ***************************************************
     */
    /**
     * return inline-javascript-Code, which is used after generating the code with the viewhelper in the generated frontend
     *
     * @param EditorArguments|null $editorArguments
     * @return string
     */
    public function parseJsFocusinContentToInnerHtml(?EditorArguments $editorArguments = null): string;
    /**
     * return autonomous javascript-code for testing proposes
     *
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function additionalJsTestingCode(?EditorArguments $editorArguments = null): string;

    /**
     * return inline-javascript-Code, which is used in the frontend after leaving the editable revision-area
     *
     * @param EditorArguments $editorArguments
     * @return string
     */
    public function parseJsFocusoutInnerHtmlToContent(?EditorArguments $editorArguments = null): string;

    /**
     * ***************************************
     * Hook-method for own data-requests
     * ***************************************
     */
    /**
     * if it return the name of a editord method to retrieve datas from anyware.
     * It will override the standardmethod of simpledataedit
     *
     * @param EditorArguments $editorArguments
     * @return string|false
     */
    public function getNameOfDataRequestMethod(EditorArguments $editorArguments);

    /**
     * if it return the name of a editord method to retrieve datas from anyware.
     * It will override the standardmethod of simpledataedit
     *
     * @param string $subject
     * @param EditorArguments $editorArguments
     * @return string|false
     */
    public function getNameOfDataUpdateMethod(EditorArguments $editorArguments);

}