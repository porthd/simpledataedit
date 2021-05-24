<?php

namespace Porthd\Simpledataedit\Domain\Model\Arguments;

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

use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Domain\Model\NeededTagArgs;
use Porthd\Simpledataedit\Exception\SimpledataeditException;

/**
 * Class EditorArguments contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
trait DiversArguments // implements DiversArgumentsInterface
{

    /**
     * @var bool
     */
    protected $always = false;
    /**
     * @var bool
     */
    protected $flagDebug = false;
    /**
     * @var string
     */
    protected $hash = '';
    /**
     * @var string
     */
    protected $log = '';
    /**
     * @var array
     */
    protected $logList = [];
    /**
     * @var array
     */
    protected $paramList = [];
    /**
     * @var string
     */
    protected $jsonRaw = '';
    /**
     * @var string
     */
    protected $roles = '';
    /**
     * @var string
     */
    protected $type = '';

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForDiversArguments():array
    {
        return [
            'always' => [
                'name' => 'always',
                'type' => 'bool',
                'description' => 'If this flag is set true, the data are editable for everyone in the frontend.',
                'flagRequired' => 0,
                'default' => '',
            ],
            NeededTagArgs::TAG_ATTR_DEBUG => [
                'name' => NeededTagArgs::TAG_ATTR_DEBUG,
                'type' => 'bool',
                'description' => 'If `'.NeededTagArgs::TAG_ATTR_DEBUG.'` is set `true`, '.
                    'then all datas needed for the updating-process are shown. '.
                    'If it is set to false, the datas are cached and only the key of the datas will be shown.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'hash' => [
                'name' => 'hash',
                'type' => 'string',
                'description' => 'This hash describes the current data. It must be equal to the hash of the current datsa in tzhe database. It help to make conflicts softer, if two editors are working on the same datas.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'log' => [
                'name' => 'log',
                'type' => 'string',
                'description' => 'Contains the logging-class',
                'flagRequired' => 0,
                'default' => '',
            ],
            'logList' => [
                'name' => 'log',
                'type' => 'string',
                'description' => 'Contains parameter for the logging-class.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'paramList' => [
                'name' => 'paramList',
                'type' => 'array',
                'description' => 'This contain special parameters for an custom editors, which may have some specialities.',
                'flagRequired' => 0,
                'default' => '',
            ],
            NeededTagArgs::TAG_ATTR_JSONRAWCONTENT => [
                'name' => NeededTagArgs::TAG_ATTR_JSONRAWCONTENT,
                'type' => 'string',
                'description' => 'This contain the raw data in `'.NeededTagArgs::TAG_ATTR_JSONRAWCONTENT.'`. The datas are transformed by htmlspecialchars. ',
                'flagRequired' => 0,
                'default' => '',
            ],
            'roles' => [
                'name' => 'roles',
                'type' => 'string',
                'description' => 'The contains the uids and/or names of usergroups, who are allowed to edit the current datas.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'type' => [
                'name' => 'delField',
                'type' => 'int',
                'description' => 'Name of the type of the value (int, str, bool) for the field in the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
                'flagRequired' => 0,
                'default' => SdeConst::MAP_DEFAULT_TYPE,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function isAlways(): bool
    {
        return $this->always;
    }

    /**
     * @param bool $always
     */
    public function setAlways(bool $always): void
    {
        $this->always = $always;
    }

    /**
     * @return bool
     */
    public function isFlagDebug(): bool
    {
        return $this->flagDebug;
    }

    /**
     * @param bool $flagDebug
     */
    public function setFlagDebug(bool $flagDebug): void
    {
        $this->flagDebug = $flagDebug;
    }

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
        if (empty(trim($hash))) {
            throw new SimpledataeditException(
                'The trimmed `' . $hash . '` for the editor must contain at least one character. Please check your settings in your viewhelper.',
                1620776324
            );
        }

        $this->hash = $hash;
    }
    /**
     * @return string
     */
    public function getLog(): string
    {
        return $this->log;
    }

    /**
     * @param string $log
     */
    public function setLog(string $log): void
    {
        $this->log = $log;
    }

    /**
     * @return array
     */
    public function getLogList(): array
    {
        return $this->logList;
    }

    /**
     * @param array $logList
     */
    public function setLogList(array $logList): void
    {
        $this->logList = $logList;
    }

    /**
     * @return array
     */
    public function getParamList(): array
    {
        return $this->paramList;
    }

    /**
     * @param array $paramList
     */
    public function setParamList(array $paramList): void
    {
        $this->paramList = $paramList;
    }

    /**
     * @return string
     */
    public function getJsonRaw(): string
    {
        return $this->jsonRaw;
    }

    /**
     * @param string $jsonRaw
     */
    public function setJsonRaw(string $jsonRaw): void
    {
        $this->jsonRaw = $jsonRaw;
    }


    /**
     * comma-separatred list of names and/or numbers
     * @return string
     */
    public function getRoles(): string
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function setRoles(string $roles): void
    {
        $this->roles = $roles;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        if (!in_array(strtolower($type), SdeConst::TYPE_DATA_LIST)) {
            throw new SimpledataeditException(
                'The type `' . $type . '` for the editor is not defined.  Please check your settings in your viewhelper.',
                1620679323
            );
        }
        $this->type = $type;
    }


}