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
 * Class CustomEditorInfo contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
interface InterRelatedArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForInterRelatedArguments() : array;

    /**
     * @return string
     */
    public function getMnTable(): string;

    /**
     * @param string $MnTable
     */
    public function setMnTable(string $mnTable): void;

    /**
     * @return string
     */
    public function getToLocalField(): string;

    /**
     * @param string $toLocalField
     */
    public function setToLocalField(string $toLocalField): void;

    /**
     * @return string
     */
    public function getToLocalSort(): string;

    /**
     * @param string $toLocalSort
     */
    public function setToLocalSort(string $toLocalSort): void;

    /**
     * @return int
     */
    public function getToLocalSortValue(): int;

    /**
     * @param int $toLocalSortValue
     */
    public function setToLocalSortValue(int $toLocalSortValue): void;

    /**
     * @return string
     */
    public function getToLocalTable(): string;

    /**
     * @param string $toLocalTable
     */
    public function setToLocalTable(string $toLocalTable): void;

    /**
     * @return string
     */
    public function getToLocalValue(): string;

    /**
     * @param string $toLocalValue
     */
    public function setToLocalValue(string $toLocalValue): void;

    /**
     * @return string
     */
    public function getToForeignField(): string;

    /**
     * @param string $toForeignField
     */
    public function setToForeignField(string $toForeignField): void;

    /**
     * @return string
     */
    public function getToForeignSort(): string;

    /**
     * @param string $toForeignSort
     */
    public function setToForeignSort(string $toForeignSort): void;

    /**
     * @return int
     */
    public function getToForeignSortValue(): int;

    /**
     * @param int $toForeignSortValue
     */
    public function setToForeignSortValue(int $toForeignSortValue): void;

    /**
     * @return string
     */
    public function getToForeignTable(): string;

    /**
     * @param string $toForeignTable
     */
    public function setToForeignTable(string $toForeignTable): void;

    /**
     * @return string
     */
    public function getToForeignValue(): string;

    /**
     * @param string $toForeignValue
     */
    public function setToForeignValue(string $toForeignValue): void;

}