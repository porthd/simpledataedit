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


/**
 * Class EditorArguments contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
interface  DiversArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForDiversArguments(): array;

    /**
     * @return bool
     */
    public function isAlways(): bool;

    /**
     * @param bool $always
     */
    public function setAlways(bool $always): void;

    /**
     * @return bool
     */
    public function isFlagDebug(): bool;

    /**
     * @param bool $flagDebug
     */
    public function setFlagDebug(bool $flagDebug): void;

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void;

    /**
     * @return string
     */
    public function getLog(): string;

    /**
     * @param string $log
     */
    public function setLog(string $log): void;

    /**
     * @return array
     */
    public function getLogList(): array;

    /**
     * @param array $logList
     */
    public function setLogList(array $logList): void;

    /**
     * @return array
     */
    public function getParamList(): array;

    /**
     * @param array $paramList
     */
    public function setParamList(array $paramList): void;

    /**
     * @return string
     */
    public function getJsonRaw(): string;

    /**
     * @param string $jsonRaw
     */
    public function setJsonRaw(string $jsonRaw): void;


    /**
     * comma-separatred list of names and/or numbers
     * @return string
     */
    public function getRoles(): string;

    /**
     * @param string $roles
     */
    public function setRoles(string $roles): void;


    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     */
    public function setType(string $type): void;


}