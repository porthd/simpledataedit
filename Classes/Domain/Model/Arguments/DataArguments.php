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

use Porthd\Simpledataedit\Exception\SimpledataeditException;

trait DataArguments // implements DataArgumentsInterface;
{

    /**
     * @var string
     */
    protected $delField = 'deleted';
    /**
     * @var string
     */
    protected $fieldName = '';
    /**
     * @var string
     */
    protected $identField = '';
    /**
     * @var int
     */
    protected $identValue = 0;
    /**
     * @var string
     */
    protected $sortField = 'sorting';
    /**
     * @var int
     */
    protected $sortValue = 0;
    /**
     * @var int
     */
    protected $storagePid = 0;
    /**
     * @var string
     */
    protected $table = '';

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForDataArguments(): array
    {
        return [
            'delField' => [
                'name' => 'delField',
                'type' => 'string',
                'description' => 'name of the field, which marked the soft-delete. (only neede in delete-processes',
                'flagRequired' => 0,
                'default' => 'deleted',
            ],
            'fieldName' => [
                'name' => 'fieldName',
                'type' => 'string',
                'description' => 'Name of the field in the model. The field is not needed in creation and  It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'identField' => [
                'name' => 'identField',
                'type' => 'string',
                'description' => 'Name of the field with the idetifier of the dataset, which is used to specified the row in the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
                'flagRequired' => 0,
                'default' => 'uid',
            ],
            'identValue' => [
                'name' => 'identValue',
                'type' => 'string',
                'description' => '',
                'flagRequired' => 0,
                'default' => '',
            ],
            'sortField' => [
                'name' => 'sortField',
                'type' => 'string',
                'description' => 'Name of the field with the idetifier of the dataset, which is used to specified the row in the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
                'flagRequired' => 0,
                'default' => 'uid',
            ],
            'sortValue' => [
                'name' => 'sortValue',
                'type' => 'string',
                'description' => '',
                'flagRequired' => 0,
                'default' => '',
            ],
            'storagePid' => [
                'name' => 'storagePid',
                'type' => 'int',
                'description' => 'Alias for pid. It contain the identifier for the TYPO3-storage-pid.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'table' => [
                'name' => 'table',
                'type' => 'string',
                'description' => 'Name of the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
                'flagRequired' => 0,
                'default' => 'tt_content',
            ],
        ];

    }

    /**
     * @return string
     */
    public function getDelField(): string
    {
        return $this->delField;
    }

    /**
     * @param string $delField
     */
    public function setDelField(string $delField): void
    {
        $this->delField = $delField;
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName): void
    {
        if (empty(trim($fieldName))) {
            throw new SimpledataeditException(
                'The trimmed name for the fieldName `' . $fieldName . '` must contain at least one character. Please check your settings in your viewhelper.',
                1620676531
            );
        }
        $this->fieldName = $fieldName;
    }

    /**
     * @return int
     */
    public function getIdentField(): int
    {
        return $this->identField;
    }

    /**
     * @param int $identField
     */
    public function setIdentField(int $identField): void
    {
        if (empty(trim($identField))) {
            throw new SimpledataeditException(
                'The integer value of identField (or alias identName) `' . $identField . '` must contain at least one charakter. Please check your settings in your viewhelper.',
                1620676542
            );
        }

        $this->identField = $identField;
    }

    /**
     * an empty string is allowed
     * @return string
     */
    public function getIdentValue(): string
    {
        return $this->identValue;
    }

    /**
     * an empty string is allowed
     * @param string $identValue
     */
    public function setIdentValue(string $identValue): void
    {
        $this->identValue = $identValue;
    }

    /**
     * @return int
     */
    public function getSortField(): int
    {
        return $this->sortField;
    }

    /**
     * @param int $sortField
     */
    public function setSortField(int $sortField): void
    {
        if (empty(trim($sortField))) {
            throw new SimpledataeditException(
                'The integer value of sortField (or alias sortName) `' . $sortField . '` must contain at least one charakter. Please check your settings in your viewhelper.',
                1620676542
            );
        }

        $this->sortField = $sortField;
    }

    /**
     * an empty string is allowed
     * @return string
     */
    public function getSortValue(): string
    {
        return $this->sortValue;
    }

    /**
     * an empty string is allowed
     * @param string $sortValue
     */
    public function setSortValue(string $sortValue): void
    {
        $this->sortValue = $sortValue;
    }

    /**
     * @return int
     */
    public function getStoragePid(): int
    {
        return $this->storagePid;
    }

    /**
     * @param int $storagePid
     */
    public function setStoragePid(int $storagePid): void
    {
        $this->storagePid = $storagePid;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     *
     * @param string $table
     */
    public function setTable(string $table): void
    {
        if (empty(trim($table))) {
            throw new SimpledataeditException(
                'The trimmed name of the table `' . $table . '` must contain at least one character. Please check your settings in your viewhelper.',
                1620676536
            );
        }

        $this->table = $table;
    }

}