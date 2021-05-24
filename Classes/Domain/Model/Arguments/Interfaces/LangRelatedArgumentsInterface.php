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

interface LangRelatedArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForLangRelatedArguments() : array;

    /**
     * @return bool
     */
    public function isFlagRelatedLangDefault(): bool;

    /**
     * @param bool $flagRelatedLangDefault
     */
    public function setFlagRelatedLangDefault(bool $flagRelatedLangDefault): void;

    /**
     * @return string
     */
    public function getRelatedLangDiffSource(): string;

    /**
     * @param string $relatedLangDiffSource
     */
    public function setRelatedLangDiffSource(string $relatedLangDiffSource): void;

    /**
     * @return int
     */
    public function getRelatedLangId(): int;

    /**
     * @param int $relatedLangId
     */
    public function setRelatedLangId(int $relatedLangId): void;

    /**
     * @return string
     */
    public function getRelatedLangListUidOrigSource(): string;

    /**
     * @param string $relatedLangListUidOrigSource
     */
    public function setRelatedLangListUidOrigSource(string $relatedLangListUidOrigSource): void;

    /**
     * @return int
     */
    public function getRelatedLangOrigUid(): int;

    /**
     * @param int $relatedLangOrigUid
     */
    public function setRelatedLangOrigUid(int $relatedLangOrigUid): void;

}