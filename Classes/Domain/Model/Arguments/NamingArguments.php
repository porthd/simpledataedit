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

trait NamingArguments // implements NamingArgumentsInterface
{

    /**
     * @var string
     */
    protected $doname = SdeConst::DONAME_EDIT_DATA;
    /**
     * @var string
     */
    protected $editor = '';
    /**
     * @var array
     */
    protected $fluidData = [];
    /**
     * @var string
     */
    protected $jsonData = '';
    /**
     * @var string
     */
    protected $yamlDataPath = '';

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForNamingArguments(): array
    {
        return [
            'doname' => [
                'name' => 'doname',
                'type' => 'string',
                'description' => 'This defines the type of action, which define the type of database-request.',
                'flagRequired' => 0,
                'default' => SdeConst::DONAME_EDIT_DATA,
            ],
            'editor' => [
                'name' => 'editor',
                'type' => 'string',
                'description' => 'This define the special class of an editor, which helps you, to get the correct editing.',
                'flagRequired' => 1,
            ],
            NeededTagArgs::TAG_ATTR_FLUID_DATA => [
                'name' => NeededTagArgs::TAG_ATTR_FLUID_DATA,
                'type' => 'array',
                'description' => 'Assoziative Array , which contain a subset of needed information for the editor.' .
                    ' (Merge-Order: defaultYaml of the editor < yamlDataPath < jsonData < fluidData < `attributes of viewhelper`) ',
                'flagRequired' => 0,
                'default' => [],
            ],
            NeededTagArgs::TAG_ATTR_JSON_DATA => [
                'name' => NeededTagArgs::TAG_ATTR_JSON_DATA,
                'type' => 'string',
                'description' => 'Assoziative Array in JSON-format, which contain a subset of needed information for the editor.' .
                    ' (Merge-Order: defaultYaml of the editor < yamlDataPath < jsonData < fluidData < `attributes of viewhelper`) ',
                'flagRequired' => 0,
                'default' => "{}",
            ],
            NeededTagArgs::TAG_ATTR_YAML_DATA => [
                'name' => NeededTagArgs::TAG_ATTR_YAML_DATA,
                'type' => 'string',
                'description' => 'This define the special class of an editor, which helps you, to get the correct editing.' .
                    ' (Merge-Order: defaultYaml of the editor < yamlDataPath < jsonData < fluidData < `attribute of viewhelper`) ',
                'flagRequired' => 0,
                'default' => "",
            ],
        ];
    }

    /**
     * @return string
     */
    public function getDoname(): string
    {
        return $this->doname;
    }

    /**
     * @param string $doname
     */
    public function setDoname(string $doname): void
    {
        if (!in_array(strtolower($doname), SdeConst::DONNAME_ALLOWED_LIST)) {
            throw new SimpledataeditException(
                'The do-name `' . $doname . '` for the editor is not defined.  Please check your settings in your viewhelper.',
                1620676323
            );
        }
        $this->doname = $doname;
    }

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
        if (empty(trim($editor))) {
            throw new SimpledataeditException(
                'The trimmed name `' . $editor . '` for the editor must contain at least one character. Please check your settings in your viewhelper.',
                1620676324
            );
        }
        $this->editor = $editor;
    }


    /**
     * @return array
     */
    public function getFluidData(): array
    {
        return $this->fluidData;
    }

    /**
     * @param array $fluidData
     */
    public function setFluidData(array $fluidData): void
    {
        $this->fluidData = $fluidData;
    }

    /**
     * @return string
     */
    public function getJsonData(): string
    {
        return $this->jsonData;
    }

    /**
     * @param string $jsonData
     */
    public function setJsonData(string $jsonData): void
    {
        $this->jsonData = $jsonData;
    }

    /**
     * @return string
     */
    public function getYamlDataPath(): string
    {
        return $this->yamlDataPath;
    }

    /**
     * @param string $yamlDataPath
     */
    public function setYamlDataPath(string $yamlDataPath): void
    {
        $this->yamlDataPath = $yamlDataPath;
    }


}