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
trait FrontendArguments // implements FrontendArgumentsInterface
{

    /**
     * @var string
     */
    protected $attributeName = '';
    /**
     * @var bool
     */
    protected $inScope = true;
    /**
     * @var string
     */
    protected $marker = '###?###';
    /**
     * @var string
     */
    protected $nullElement = '';
    /**
     * @var string
     */
    protected $selector = '';
    /**
     * @var string
     */
    protected $template = '';

    /**
     * @return array[]
     */
    public function getInitViewhelperParameterForFrontendArguments(): array
    {
        return [
            'attributeName' => [
                'name' => 'attributeName',
                'type' => 'string',
                'description' => 'The name of the attribute, which you want to edit. This could perhaps be the text in the alt-attribute of an image.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'inScope' => [
                'name' => 'inScope',
                'type' => 'bool',
                'description' => 'If it is true, the selector must be found in the webcomponent. Otherwise you have to searc in the whole document.',
                'flagRequired' => 0,
                'default' => 1, // selector restricted to DOM in the webcompunent
            ],
            'marker' => [
                'name' => 'marker',
                'type' => 'string',
                'description' => 'Marker in the template, which define the region of the raw content. in example you may edite datas, which are wrap by an localized text.',
                'flagRequired' => 0,
                'default' => '###?###',
            ],
            'nullElement' => [
                'name' => 'nullElement',
                'type' => 'string',
                'description' => 'You remove an element. YShould it be replace by an Null-Element-Entry?',
                'flagRequired' => 0,
                'default' => '',
            ],
            'selector' => [
                'name' => 'selector',
                'type' => 'string',
                'description' => 'Define the position of the data, you want to edit.',
                'flagRequired' => 0,
                'default' => '',
            ],
            'template' => [
                'name' => 'template',
                'type' => 'string',
                'description' => 'The template describes the position, where you find the datas. (You want to edit one of some lements, which is wraped by an localized text. ',
                'flagRequired' => 0,
                'default' => '',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAttributeName(): string
    {
        return $this->attributeName;
    }

    /**
     * @param string $attributeName
     */
    public function setAttributeName(string $attributeName): void
    {
        $this->attributeName = $attributeName;
    }

    /**
     * @return bool
     */
    public function isInScope(): bool
    {
        return $this->inScope;
    }

    /**
     * @param bool $inScope
     */
    public function setInScope(bool $inScope): void
    {
        $this->inScope = $inScope;
    }

    /**
     * @return string
     */
    public function getMarker(): string
    {
        return $this->marker;
    }

    /**
     * @param string $marker
     */
    public function setMarker(string $marker): void
    {
        $this->marker = $marker;
    }

    /**
     * @return string
     */
    public function getNullElement(): string
    {
        return $this->nullElement;
    }

    /**
     * @param string $nullElement
     */
    public function setNullElement(string $nullElement): void
    {
        $this->nullElement = $nullElement;
    }

    /**
     * @return string
     */
    public function getSelector(): string
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     */
    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

}