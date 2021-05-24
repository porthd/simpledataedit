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

/**
 * Trait LangRelatedArguments
 * @package Porthd\Simpledataedit\Domain\Model\Arguments
 *
 * remark i am not sure, if i need this stuff really in TYPO3.
 */
trait LangRelatedArguments // implements LangRelatedArgumentsInterface
{

    /**
     * @var bool
     */
    protected $flagRelatedLangDefault = true;
    /**
     * @var string
     */
    protected $relatedLangDiffSource = '';
    /**
     * @var int
     */
    protected $relatedLangId = 0;
    /**
     * @var string
     */
    protected $relatedLangListUidOrigSource = '';
    /**
     * @var int
     */
    protected $relatedLangOrigUid = 0;

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForLangRelatedArguments(): array
    {
        return [
            'flagRelatedLangDefault' => [
                'name' => 'flagRelatedLangDefault',
                'type' => 'bool',
                'description' => 'not used yet: flag to create or delete a related data-object for another language.',
                'flagRequired' => 0,
                'default' => false,
            ],
            'relatedLangDiffSource' => [
                'name' => 'relatedLangDiffSource',
                'type' => 'string',
                'description' => 'not used yet: Serialized string of the differences to original source in the related table for usage in the Backend',
                'flagRequired' => 0,
                'default' => '',
            ],
            'relatedLangId' => [
                'name' => 'relatedLangId',
                'type' => 'int',
                'description' => 'not used yet: id of the used language in that datarow of the related table.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'relatedLangListUidOrigSource' => [
                'name' => 'relatedLangListUidOrigSource',
                'type' => 'string',
                'description' => 'not used yet: Serialized string of the original source of the datarow of the relate table for usage in the Backend',
                'flagRequired' => 0,
                'default' => '',
            ],
            'relatedLangOrigUid' => [
                'name' => 'relatedLangOrigUid',
                'type' => 'int',
                'description' => 'not used yet: uid of the data row with the original datas.',
                'flagRequired' => 0,
                'default' => 0,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function isFlagRelatedLangDefault(): bool
    {
        return $this->flagRelatedLangDefault;
    }

    /**
     * @param bool $flagRelatedLangDefault
     */
    public function setFlagRelatedLangDefault(bool $flagRelatedLangDefault): void
    {
        $this->flagRelatedLangDefault = $flagRelatedLangDefault;
    }

    /**
     * @return string
     */
    public function getRelatedLangDiffSource(): string
    {
        return $this->relatedLangDiffSource;
    }

    /**
     * @param string $relatedLangDiffSource
     */
    public function setRelatedLangDiffSource(string $relatedLangDiffSource): void
    {
        $this->relatedLangDiffSource = $relatedLangDiffSource;
    }

    /**
     * @return int
     */
    public function getRelatedLangId(): int
    {
        return $this->relatedLangId;
    }

    /**
     * @param int $relatedLangId
     */
    public function setRelatedLangId(int $relatedLangId): void
    {
        $this->relatedLangId = $relatedLangId;
    }

    /**
     * @return string
     */
    public function getRelatedLangListUidOrigSource(): string
    {
        return $this->relatedLangListUidOrigSource;
    }

    /**
     * @param string $relatedLangListUidOrigSource
     */
    public function setRelatedLangListUidOrigSource(string $relatedLangListUidOrigSource): void
    {
        $this->relatedLangListUidOrigSource = $relatedLangListUidOrigSource;
    }

    /**
     * @return int
     */
    public function getRelatedLangOrigUid(): int
    {
        return $this->relatedLangOrigUid;
    }

    /**
     * @param int $relatedLangOrigUid
     */
    public function setRelatedLangOrigUid(int $relatedLangOrigUid): void
    {
        $this->relatedLangOrigUid = $relatedLangOrigUid;
    }

}