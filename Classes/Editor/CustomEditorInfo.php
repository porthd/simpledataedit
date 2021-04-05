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

use Porthd\Simpledataedit\Config\SdeConst;

/**
 * Class CustomEditorInfo contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
class CustomEditorInfo implements CustomEditorInfoInterface
{

    /** @var int */
    protected $pid = 0;

    /**
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid(int $pid): void
    {
        $this->pid = $pid;
    }

    /** @var string */
    protected $message = '';

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param string $message
     */
    public function addMessage(string $message): void
    {
        $this->message .= $message . "\r";
    }

    /**
     * @var string
     */
    protected $table = 'tt_content';

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        if (!is_string($table)) {
            $this->noError = false;
            $table = '';
            $this->message .= 'The value for the table `' . print_r($table, true) . "` is not a string.\r";
        }
        $this->table = $table;
    }

    /**
     * @var int
     */
    protected $uid = 0;

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid(int $uid): void
    {
        if ((!is_numeric($uid)) || ((int)$uid <= 0)) {
            $this->noError = false;
            $uid = 0;
            $this->message .= 'The value for uid `' . print_r($uid,
                    true) . "`cannot interpreted as a positive integer.\r";
        }
        $this->uid = $uid;
    }

    /**
     * @var string
     */
    protected $fieldname = '';

    /**
     * @return string
     */
    public function getFieldname(): string
    {
        return $this->fieldname;
    }

    /**
     * @param string $fieldname
     */
    public function setFieldname(string $fieldname):void
    {
        if (!is_string($fieldname)) {
            $this->noError = false;
            $fieldname = '';
            $this->message .= 'The name for the fieldname ' . print_r($fieldname,
                    true) . "is not a string or contains not allowed signs.\r";
        }

        $this->fieldname = $fieldname;
    }


    /**
     * @var int
     */
    protected $type = SdeConst::MAP_DEFAULT_TYPE;

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        if ((!is_int($type)) ||
            (!in_array($type, SdeConst::MAP_ALLOWED_TYPE))
        ) {
            $this->noError = false;
            $this->message .= 'The name for the type ' . print_r($type, true) . "is not a integer.\r";
            $type = SdeConst::MAP_DEFAULT_TYPE;
        }

        $this->type = $type;
    }

    /**
     * @var string
     */
    protected $identname = '';

    /**
     * @return string
     */
    public function getIdentname(): string
    {
        return $this->identname;
    }

    /**
     * @param string $identname
     */
    public function setIdentname(string $identname): void
    {
        if (!is_string($identname)) {
            $this->noError = false;
            $identname = '';
            $this->message .= 'The name for the identname ' . print_r($identname,
                    true) . "is not a string or contains not allowed signs.\r";
        }

        $this->identname = $identname;
    }

    /**
     * @var string
     */
    protected $raw = '';

    /**
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    /**
     * @param string $raw
     */
    public function setRaw(string $raw): void
    {
        if (!is_string($raw)) {
            $this->noError = false;
            $raw = '';
            $this->message .= 'The name for the raw ' . print_r($raw,
                    true) . "is not a string or contains not allowed signs.\r";
        }

        $this->raw = $raw;
    }


    /**
     * @var string
     */
    protected $untrimmedRaw = '';

    /**
     * @return string
     */
    public function getUntrimmedRaw(): string
    {
        return $this->untrimmedRaw;
    }

    /**
     * @param string $untrimmedRaw
     */
    public function setUntrimmedRaw(string $untrimmedRaw): void
    {
        if (!is_string($untrimmedRaw)) {
            $this->noError = false;
            $untrimmedRaw = '';
            $this->message .= 'The name for the untrimmedRaw ' . print_r($untrimmedRaw,
                    true) . "is not a string or contains not allowed signs.\r";
        }

        $this->untrimmedRaw = $untrimmedRaw;
    }

    /**
     * @var string
     */
    protected $editor = '';

    /**
     * @return string
     */
    public function getEditor(): string
    {
        return $this->editor;
    }

    /**
     * @param string $editor
     */
    public function setEditor(string $editor): void
    {
        if (!is_string($editor)) {
            $this->noError = false;
            $editor = '';
            $this->message .= 'The name for the editor ' . print_r($editor,
                    true) . "is not a string or contains not allowed signs.\r";
        }

        $this->editor = $editor;
    }


    /**
     * @var string
     */
    protected $hash = '';

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        if (!is_string($hash)) {
            $this->noError = false;
            $hash = '';
            $this->message .= 'The name for the hash ' . print_r($hash,
                    true) . "is not a string or contains not allowed signs.\r";
        }

        $this->hash = $hash;
    }

    /**
     * @var string
     */
    protected $params = '[]';  // default empty String

    /**
     * @return string JSON-String
     */
    public function getParams(): string
    {
        return $this->params;
    }

    /**
     * @param string $params JSONString
     */

    public function setParams(string $params = '[]'): void
    {
        if (!is_string($params)) {
            $this->noError = false;
            $this->message .= 'The value for the params ' . print_r($params, true) . "is not an string.\r";
        }
        $this->params = $params;
    }

}