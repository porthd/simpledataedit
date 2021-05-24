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

interface RelatedArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForRelatedArguments() : array;

    /**
     * @return string
     */
    public function getRelatedByField(): string;

    /**
     * @param string $relatedByField
     */
    public function setRelatedByField(string $relatedByField): void;

    /**
     * @return string
     */
    public function getRelatedToField(): string;

    /**
     * @param string $relatedToField
     */
    public function setRelatedToField(string $relatedToField): void;

    /**
     * @return string
     */
    public function getRelatedSortField(): string;

    /**
     * @param string $relatedSortField
     */
    public function setRelatedSortField(string $relatedSortField): void;

    /**
     * @return int
     */
    public function getRelatedSortValue(): int;

    /**
     * @param int $relatedSortValue
     */
    public function setRelatedSortValue(int $relatedSortValue): void;

    /**
     * @return string
     */
    public function getRelatedStoragePid(): string;

    /**
     * @param string $relatedStoragePid
     */
    public function setRelatedStoragePid(string $relatedStoragePid): void;

    /**
     * @return string
     */
    public function getRelatedTable(): string;

    /**
     * @param string $relatedTable
     */
    public function setRelatedTable(string $relatedTable): void;

    /**
     * @return int
     */
    public function getRelatedValue(): int;

    /**
     * @param int $relatedValue
     */
    public function setRelatedValue(int $relatedValue): void;

}