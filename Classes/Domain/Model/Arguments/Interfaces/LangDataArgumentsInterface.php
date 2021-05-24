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
interface LangDataArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForLangDataArguments() : array;

    /**
     * @return bool
     */
    public function isFlagLangDefault(): bool;

    /**
     * @param bool $flagLangDefault
     */
    public function setFlagLangDefault(bool $flagLangDefault): void;

    /**
     * @return string
     */
    public function getLangDiffSource(): string;

    /**
     * @param string $langDiffSource
     */
    public function setLangDiffSource(string $langDiffSource): void;

    /**
     * @return int
     */
    public function getLangId(): int;

    /**
     * @param int $langId
     */
    public function setLangId(int $langId): void;

    /**
     * @return string
     */
    public function getLangListUidOrigSource(): string;

    /**
     * @param string $langListUidOrigSource
     */
    public function setLangListUidOrigSource(string $langListUidOrigSource): void;

    /**
     * @return int
     */
    public function getLangOrigUid(): int;

    /**
     * @param int $langOrigUid
     */
    public function setLangOrigUid(int $langOrigUid): void;

}