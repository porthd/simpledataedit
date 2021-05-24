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

interface HelperArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForHelperArguments() : array;

    /**
     * @return array
     */
    public function putInListOfJsonValues(string $key,string $jsonValue ='""'): array;

    /**
     * @return array
     */
    public function getListOfJsonValues(): array;

    /**
     * @param array $listOfJsonValues
     */
    public function setListOfJsonValues(array $listOfJsonValues): void;

    /**
     * ggenerate a MD5-hashvalue based on the values stored in `$this->ListOfJsonValues`
     *
     * @return void
     */
    public function makeAttributesHash($key = 'jsonValue'): void;

    /**
     * @return string
     */
    public function getAttributesHash(): string;

    /**
     * @param string $attributesHash
     */
    public function setAttributesHash(string $attributesHash): void;

}