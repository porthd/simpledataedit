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
 * interface for the class CustomEditorInfo contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
interface CustomEditorInfoInterface
{
    /**
     * @return int
     */
    public function getPid(): int;

    /**
     * @param int $pid
     */
    public function setPid(int $pid): void;

    /**
     * @return string
     */
    public function getTable(): string;

    /**
     * @param string $table
     */
    public function setTable(string $table): void;


    /**
     * @return int
     */
    public function getUid(): int;

    /**
     * @param int $uid
     */
    public function setUid(int $uid): void;

    /**
     * @return string
     */
    public function getFieldname(): string;

    /**
     * @param $fieldname
     */
    public function setFieldname(string $fieldname): void;

    /**
     * @return int
     */
    public function getType(): int;

    /**
     * @param int $type
     */
    public function setType(int $type): void;

    /**
     * @return string
     */
    public function getIdentname(): string;

    /**
     * @param $identname
     */
    public function setIdentname(string $identname): void;

    /**
     * @return string
     */
    public function getRaw(): string;

    /**
     * raw means the content
     * @param string $raw
     */
    public function setRaw(string $raw): void;

    /**
     * @return string
     */
    public function getUntrimmedRaw(): string;

    /**
     * untrimmedRaw means the content
     * @param string $untrimmedRaw
     */
    public function setUntrimmedRaw(string $untrimmedRaw): void;

    /**
     * @return string
     */
    public function getEditor(): string;

    /**
     * @param $editor
     */
    public function setEditor(string $editor): void;

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @param $hash
     */
    public function setHash(string $hash): void;

    /**
     * @return string JSON-String
     */
    public function getParams(): string;

    /**
     * @param string $params JSONString
     */
    public function setParams(string $params = '[]'): void;

}