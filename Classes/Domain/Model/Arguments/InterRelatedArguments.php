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

trait InterRelatedArguments // implements InterRelatedArgumentsInterface
{

    /**
     * @var string
     */
    protected $mnTable = '';
    /**
     * @var string
     */
    protected $toLocalField = 'uid_local';
    /**
     * @var string
     */
    protected $toLocalSort = 'sorting';
    /**
     * @var int
     */
    protected $toLocalSortValue = 0;
    /**
     * @var string
     */
    protected $toLocalTable = '';
    /**
     * @var string
     */
    protected $toLocalValue = '';
    /**
     * @var string
     */
    protected $toForeignField = 'uid_foreign';
    /**
     * @var string
     */
    protected $toForeignSort = 'sorting_foreign';
    /**
     * @var int
     */
    protected $toForeignSortValue = 0;
    /**
     * @var string
     */
    protected $toForeignTable = '';
    /**
     * @var string
     */
    protected $toForeignValue = '';

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForInterRelatedArguments(): array
    {
        return [
            'mnTable' => [
                'name' => 'mnTable',
                'type' => 'string',
                'description' => 'This contains the name of the relationstable. It will used for the editing of relations',
                'flagRequired' => 0,
                'default' => '',
            ],
            'toLocalField' => [
                'name' => 'toLocalField',
                'type' => 'string',
                'description' => 'TYPO3 has the convention, to name the relationfield as `uid_local`.',
                'flagRequired' => 0,
                'default' => 'uid_local',
            ],
            'toLocalSort' => [
                'name' => 'toLocalSort',
                'type' => 'string',
                'description' => 'This Fieldname is used, if the peer in the foreigntables of an datarow in the local table are shown in a sorted way.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'toLocalSortValue' => [
                'name' => 'toLocalSortValue',
                'type' => 'int',
                'description' => 'This value define the sorting-order of some related array with the same pid.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'toLocalTable' => [
                'name' => 'toLocalTable',
                'type' => 'string',
                'description' => 'This extension won`t use the TCA to determine the related local field, because the convention make too much assumptions. that cause unwilled mistakes.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'toLocalValue' => [
                'name' => 'toLocalValue',
                'type' => 'int',
                'description' => 'The id for the `uid_local` should be a positive integer.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'toForeignField' => [
                'name' => 'toForeignField',
                'type' => 'string',
                'description' => 'TYPO3 has the convention, to name the relationfield as `uid_foreign`.',
                'flagRequired' => 0,
                'default' => 'uid_foreign',
            ],
            'toForeignSort' => [
                'name' => 'toLocalSort',
                'type' => 'string',
                'description' => 'This variable is used, if the peers in the local-tables of an datarow relativ to en foreign table are shown in a sorted way.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'toForeignSortValue' => [
                'name' => 'toLocalSortValue',
                'type' => 'int',
                'description' => 'This value define the sorting-order of some related array with the same pid.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'toForeignTable' => [
                'name' => 'toForeignTable',
                'type' => 'string',
                'description' => 'This extension won`t use the TCA to determine the related local field, because the convention make too much assumptions. that cause unwilled mistakes.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'toForeignValue' => [
                'name' => 'toForeignValue',
                'type' => 'string',
                'description' => 'The id for the uid_foreign should be an positive integer.',
                'flagRequired' => 0,
                'default' => '',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getMnTable(): string
    {
        return $this->mnTable;
    }

    /**
     * @param string $MnTable
     */
    public function setMnTable(string $mnTable): void
    {
        if (empty(trim($mnTable))) {
            throw new SimpledataeditException(
                'The trimmed mn-tablename `' . $mnTable . '` for the editor must contain at least one character. Please check your settings in your viewhelper.',
                1620986324
            );
        }

        $this->mnTable = trim($mnTable);
    }

    /**
     * @return string
     */
    public function getToLocalField(): string
    {
        return $this->toLocalField;
    }

    /**
     * @param string $toLocalField
     */
    public function setToLocalField(string $toLocalField): void
    {
        $this->toLocalField = $toLocalField;
    }

    /**
     * @return string
     */
    public function getToLocalSort(): string
    {
        return $this->toLocalSort;
    }

    /**
     * @param string $toLocalSort
     */
    public function setToLocalSort(string $toLocalSort): void
    {
        $this->toLocalSort = $toLocalSort;
    }

    /**
     * @return int
     */
    public function getToLocalSortValue(): int
    {
        return $this->toLocalSortValue;
    }

    /**
     * @param int $toLocalSortValue
     */
    public function setToLocalSortValue(int $toLocalSortValue): void
    {
        $this->toLocalSortValue = $toLocalSortValue;
    }

    /**
     * @return string
     */
    public function getToLocalTable(): string
    {
        return $this->toLocalTable;
    }

    /**
     * @param string $toLocalTable
     */
    public function setToLocalTable(string $toLocalTable): void
    {
        $this->toLocalTable = $toLocalTable;
    }

    /**
     * @return string
     */
    public function getToLocalValue(): string
    {
        return $this->toLocalValue;
    }

    /**
     * @param string $toLocalValue
     */
    public function setToLocalValue(string $toLocalValue): void
    {
        $this->toLocalValue = $toLocalValue;
    }

    /**
     * @return string
     */
    public function getToForeignField(): string
    {
        return $this->toForeignField;
    }

    /**
     * @param string $toForeignField
     */
    public function setToForeignField(string $toForeignField): void
    {
        $this->toForeignField = $toForeignField;
    }

    /**
     * @return int
     */
    public function getToForeignSortValue(): int
    {
        return $this->toForeignSortValue;
    }

    /**
     * @param int $toForeignSortValue
     */
    public function setToForeignSortValue(int $toForeignSortValue): void
    {
        $this->toForeignSortValue = $toForeignSortValue;
    }

    /**
     * @return string
     */
    public function getToForeignSort(): string
    {
        return $this->toForeignSort;
    }

    /**
     * @param string $toForeignSort
     */
    public function setToForeignSort(string $toForeignSort): void
    {
        $this->toForeignSort = $toForeignSort;
    }

    /**
     * @return string
     */
    public function getToForeignTable(): string
    {
        return $this->toForeignTable;
    }

    /**
     * @param string $toForeignTable
     */
    public function setToForeignTable(string $toForeignTable): void
    {
        $this->toForeignTable = $toForeignTable;
    }

    /**
     * @return string
     */
    public function getToForeignValue(): string
    {
        return $this->toForeignValue;
    }

    /**
     * @param string $toForeignValue
     */
    public function setToForeignValue(string $toForeignValue): void
    {
        $this->toForeignValue = $toForeignValue;
    }

}