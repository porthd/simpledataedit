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

use Exception;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\NamingArgumentsInterface;
use Porthd\Simpledataedit\Exception\SimpledataeditException;

/**
 * Class EditorArguments contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
interface DataArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForDataArguments() : array;

    /**
     * @return string
     */
    public function getFieldName(): string;


    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName): void;

    /**
     * @return string
     */
    public function getIdentField(): string;

    /**
     * @param string $identField
     */
    public function setIdentField(string $identField): void;


    /**
     * an empty string is allowed
     * @return string
     */
    public function getIdentValue(): string;

    /**
     * an empty string is allowed
     * @param string $identValue
     */
    public function setIdentValue(string $identValue): void;

    /**
     * @return string
     */
    public function getStoragePid(): string;

    /**
     * @param string $storagePid
     */
    public function setStoragePid(string $storagePid): void;


    /**
     * @return string
     */
    public function getTable(): string;

    /**
     *
     * @param string $table
     */
    public function setTable(string $table): void;


}