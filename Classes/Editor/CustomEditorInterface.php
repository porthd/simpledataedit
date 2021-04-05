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

/**
 * Use of classes for more flexibility in the case of frontend-editing.
 * The interface define the methods, which are needed for an update single datefield by this extension.
 *
 */
interface CustomEditorInterface
{

    /**
     * A object should have some selfawareness. So i can be recognized in the bunch.
     *
     * @return string
     */
    public static function whoAmI():string;

    /**
     * return inline-javascript-Code, which is used by the viewhelper
     * @param CustomEditorInfoInterface $baseData
     * @return string|false
     */
    /**
     * @param CustomEditorInfoInterface $baseData
     * @param string|null $replaceData If the data is not equal to `null`, then the data will used in place of  content in $baseDate for the generation of the hash-value. (needed for Hash-Compare)
     * @return string|false
     */
    public function generateHash(CustomEditorInfoInterface $baseData, $replaceData=null);

    /**
     * the raw-content is containe in Gettter/Setter-Class in (protected) $customParameter->raw
     *
     * normalize code in the middleware, before it will rendered in the template
     * remark: Perhaps you want to convert a unixttimestamp to an regular date, because that is easier in JavaScript
     * to handle or you wantnt to convert some links in an RTE-Editing
     *
     * @param CustomEditorInfo $customParameter
     * @return string
     */
    public function parseRawInViewhelperPhp(CustomEditorInfo $customParameter ) : string;

    /**
     * normalize code in the middleware, before it will send to someting else
     * Perhaps you want to reanalyse some links, to rebuild a RTE-field
     * @param string $subject
     * @param CustomEditorInfo $customParameter
     * @return string
     */
    public function parseUpdateFlowPhp(string $subject, CustomEditorInfo $customParameter ) : string;


    /**
     * ***************************************************
     * own javascript-method to normalize rendered datas
     * ***************************************************
     */
    /**
     * return inline-javascript-Code, which is used after generating the code with the viewhelper in the generated frontend
     *
     * @return string
     */
    public function parseJsFocusinContentToInnerHtml(): string;

    /**
     * return inline-javascript-Code, which is used in the frontend after leaving the editable revision-area
     *
     * @return string
     */
    public function parseJsFocusoutInnerHtmlToContent(): string;

    /**
     * ***************************************
     * Hook-method for own data-requests
     * ***************************************
     */
    /**
     * if it return the name of a editord method to retrieve datas from anyware.
     * It will override the standardmethod of simpledataedit
     *
     * @param CustomEditorInfo $customParameter
     * @return string|false
     */
    public function getNameOfDataRequestMethod(CustomEditorInfo $customParameter);

    /**
     * if it return the name of a editord method to retrieve datas from anyware.
     * It will override the standardmethod of simpledataedit
     *
     * @param string $subject
     * @param CustomEditorInfo $customParameter
     * @return string|false
     */
    public function getNameOfDataUpdateMethod(CustomEditorInfo $customParameter);

}