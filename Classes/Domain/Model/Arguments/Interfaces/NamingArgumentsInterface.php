<?php

namespace Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces;

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

use Porthd\Simpledataedit\Exception\SimpledataeditException;

/**
 * Class CustomEditorInfo contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
interface NamingArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForNamingArguments() : array;

    /**
     * $editor contains the name of the special frontend-editing-process
     * The name must not be empty.
     * 
     * @return string
     */
    public function getEditor(): string;

    /**
     * @param string $editor
     */
    public function setEditor(string $editor): void;


    /**
     * $doname contains from a list of names the type of a frontend-editing-process
     * The name implies, which classes of parameter parameter ar needed
     *
     * @return string
     */
    public function getDoname(): string;

    /**
     * @param string $doname
     */
    public function setDoname(string $doname): void;


    /**
     * $fluidData contains from a list of key-value-pairs, where the key is a name of an attributes used in the editor-viewhelper.
     * This implies, that the parameter is really optional.
     *
     * @return array
     */
    public function getFluidData(): array;

    /**
     * @param array $fluidData
     */
    public function setFluidData(array $fluidData): void;

    /**
     * $jsonDat contains a jsonstring, which contains a list of key-value-pairs, 
     * where the key is a name of an attributes used in the editor-viewhelper.
     * This implies, that the parameter is really optional.
     * 
     * @return string
     */
    public function getJsonData(): string;

    /**
     * @param string $jsonData
     */
    public function setJsonData(string $jsonData): void;

    /**
     * $yamlDataPath contains from path to an file, which contains a list of key-value-pairs.
     * The keys of the list in the file must be names of an attributes used in the editor-viewhelper.
     * This implies, that this parameter is really optional.
     *
     * @return string
     */
    public function getYamlDataPath(): string;

    /**
     * @param string $yamlDataPath
     */
    public function setYamlDataPath(string $yamlDataPath): void;

}