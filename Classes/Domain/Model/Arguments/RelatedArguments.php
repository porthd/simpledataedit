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
use Porthd\Simpledataedit\Exception\SimpledataeditException;

trait RelatedArguments // implements RelatedArgumentsInterface
{
    /**
     * @var string
     */
    protected $relatedByField = '';
    /**
     * @var string
     */
    protected $relatedToField = '';
    /**
     * @var string
     */
    protected $relatedSortField = '';
    /**
     * @var int
     */
    protected $relatedSortValue = 0;
    /**
     * @var string
     */
    protected $relatedStoragePid = '';
    /**
     * @var string
     */
    protected $relatedTable = '';
    /**
     * @var int
     */
    protected $relatedValue = 0;

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForRelatedArguments(): array
    {
        return [
            'relatedByField' => [
                'name' => 'relatedByField',
                'type' => 'string',
                'description' => 'This is the uid-field of the current-parent data-object.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'relatedToField' => [
                'name' => 'relatedToField',
                'type' => 'string',
                'description' => 'A parent-Element has a related field, where it counts his own childs.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'relatedSortField' => [
                'name' => 'relatedSortField',
                'type' => 'string',
                'description' => 'This contains the name of the sorting field.',
                'flagRequired' => 0,
                'default' => 'sorting',
            ],
            'relatedSortValue' => [
                'name' => 'relatedSortValue',
                'type' => 'int',
                'description' => 'The value define the position in the sorting.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'relatedStoragePid' => [
                'name' => 'relatedStoragePid',
                'type' => 'int',
                'description' => 'This define the page-id of the storage for the related data.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'relatedTable' => [
                'name' => 'relatedTable',
                'type' => 'string',
                'description' => 'This contain the name of the related table.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'relatedValue' => [
                'name' => 'relatedValue',
                'type' => 'int',
                'description' => 'This defines the type of action, which define the type of database-request.',
                'flagRequired' => 0,
                'default' => '',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getRelatedByField(): string
    {
        return $this->relatedByField;
    }

    /**
     * @param string $relatedByField
     */
    public function setRelatedByField(string $relatedByField): void
    {
        $this->relatedByField = $relatedByField;
    }

    /**
     * @return string
     */
    public function getRelatedToField(): string
    {
        return $this->relatedToField;
    }

    /**
     * @param string $relatedToField
     */
    public function setRelatedToField(string $relatedToField): void
    {
        $this->relatedToField = $relatedToField;
    }

    /**
     * @return string
     */
    public function getRelatedSortField(): string
    {
        return $this->relatedSortField;
    }

    /**
     * @param string $relatedSortField
     */
    public function setRelatedSortField(string $relatedSortField): void
    {
        $this->relatedSortField = $relatedSortField;
    }

    /**
     * @return int
     */
    public function getRelatedSortValue(): int
    {
        return $this->relatedSortValue;
    }

    /**
     * @param int $relatedSortValue
     */
    public function setRelatedSortValue(int $relatedSortValue): void
    {
        $this->relatedSortValue = $relatedSortValue;
    }

    /**
     * @return int
     */
    public function getRelatedStoragePid(): int
    {
        return $this->relatedStoragePid;
    }

    /**
     * @param int $relatedStoragePid
     */
    public function setRelatedStoragePid(int $relatedStoragePid): void
    {
        $this->relatedStoragePid = $relatedStoragePid;
    }

    /**
     * @return string
     */
    public function getRelatedTable(): string
    {
        return $this->relatedTable;
    }

    /**
     * @param string $relatedTable
     */
    public function setRelatedTable(string $relatedTable): void
    {
        if (empty(trim($relatedTable))) {
            throw new SimpledataeditException(
                'The trimmed tablename `' . $relatedTable . '` for the editor must contain at least one character. Please check your settings in your viewhelper.',
                1621276324
            );
        }
        $this->relatedTable = trim($relatedTable);
    }

    /**
     * @return int
     */
    public function getRelatedValue(): int
    {
        return $this->relatedValue;
    }

    /**
     * @param int $relatedValue
     */
    public function setRelatedValue(int $relatedValue): void
    {
        $this->relatedValue = $relatedValue;
    }


}