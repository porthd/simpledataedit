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
trait LangDataArguments // implements LangDataArgumentsInterface
{

    /**
     * The current field depends on the convention in TYPO3. They are currently not used.
     */

    /**
     * @var bool
     */
    protected $flagLangDefault = true;
    /**
     * @var string
     */
    protected $langDiffSource = '';
    /**
     * @var int
     */
    protected $langId = 0;
    /**
     * @var string
     */
    protected $langListUidOrigSource = '';
    /**
     * @var int
     */
    protected $langOrigUid = 0;

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForLangDataArguments(): array
    {
        return [
            'flagLangDefault' => [
                'name' => 'flagLangDefault',
                'type' => 'bool',
                'description' => 'not used yet: flag to create or delete a data-object for another language.',
                'flagRequired' => 0,
                'default' => false,
            ],
            'langDiffSource' => [
                'name' => 'langDiffSource',
                'type' => 'string',
                'description' => 'not used yet: Serialized string of the differences to original source for usage in the Backend',
                'flagRequired' => 0,
                'default' => '',
            ],
            'langId' => [
                'name' => 'langId',
                'type' => 'int',
                'description' => 'not used yet: id of the used language in that datarow.',
                'flagRequired' => 0,
                'default' => 0,
            ],
            'langListUidOrigSource' => [
                'name' => 'langListUidOrigSource',
                'type' => 'string',
                'description' => 'not used yet: Serialized string of the original source for usage in the Backend',
                'flagRequired' => 0,
                'default' => '',
            ],
            'langOrigUid' => [
                'name' => 'langOrigUid',
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
    public function isFlagLangDefault(): bool
    {
        return $this->flagLangDefault;
    }

    /**
     * @param bool $flagLangDefault
     */
    public function setFlagLangDefault(bool $flagLangDefault): void
    {
        $this->flagLangDefault = $flagLangDefault;
    }

    /**
     * @return string
     */
    public function getLangDiffSource(): string
    {
        return $this->langDiffSource;
    }

    /**
     * @param string $langDiffSource
     */
    public function setLangDiffSource(string $langDiffSource): void
    {
        $this->langDiffSource = $langDiffSource;
    }

    /**
     * @return int
     */
    public function getLangId(): int
    {
        return $this->langId;
    }

    /**
     * @param int $langId
     */
    public function setLangId(int $langId): void
    {
        $this->langId = $langId;
    }

    /**
     * @return string
     */
    public function getLangListUidOrigSource(): string
    {
        return $this->langListUidOrigSource;
    }

    /**
     * @param string $langListUidOrigSource
     */
    public function setLangListUidOrigSource(string $langListUidOrigSource): void
    {
        $this->langListUidOrigSource = $langListUidOrigSource;
    }

    /**
     * @return int
     */
    public function getLangOrigUid(): int
    {
        return $this->langOrigUid;
    }

    /**
     * @param int $langOrigUid
     */
    public function setLangOrigUid(int $langOrigUid): void
    {
        $this->langOrigUid = $langOrigUid;
    }

}