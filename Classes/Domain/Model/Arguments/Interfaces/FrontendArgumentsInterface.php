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
interface FrontendArgumentsInterface
{
    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForFrontendArguments() : array;

    /**
     * @return string
     */
    public function getAttributeName(): string;

    /**
     * @param string $attributeName
     */
    public function setAttributeName(string $attributeName): void;

    /**
     * @return bool
     */
    public function isInScope(): bool;

    /**
     * @param bool $inScope
     */
    public function setInScope(bool $inScope): void;

    /**
     * @return string
     */
    public function getMarker(): string;

    /**
     * @param string $marker
     */
    public function setMarker(string $marker): void;

    /**
     * @return string
     */
    public function getNullElement(): string;

    /**
     * @param string $nullElement
     */
    public function setNullElement(string $nullElement): void;

    /**
     * @return string
     */
    public function getSelector(): string;

    /**
     * @param string $selector
     */
    public function setSelector(string $selector): void;

    /**
     * @return string
     */
    public function getTemplate(): string;

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void;

}