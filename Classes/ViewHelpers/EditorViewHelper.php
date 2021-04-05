<?php

namespace Porthd\Simpledataedit\ViewHelpers;

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
use Porthd\Simpledataedit\Editor\CustomEditorInfo;
use Porthd\Simpledataedit\Editor\CustomEditorInterface;
use Porthd\Simpledataedit\Editor\PlainTextEditor;
use Porthd\Simpledataedit\Exception\SimpledataeditException;
use Porthd\Simpledataedit\Utilities\CustomEditorInfoUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class EditorViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'simpledataedit';

    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        /** Parameter defines update-Process in direction to the database */
        $this->registerArgument('editor', 'string',
            'identifier to customized editor-processor-class',
            true);
        $this->registerArgument('pid', 'int',
            'page-id, where the content-element is shown.',
            true);
        $this->registerArgument('raw', 'string',
            'This contains the raw-data. It is the base for the hash-value.',
            true);

        $this->registerArgument('fieldname', 'string',
            'Name of the field in the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
            true);
        $this->registerArgument('uid', 'int',
            'Number of the uid, which specifie the row in the model by the uid-field. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
            true);
        $this->registerArgument('type', 'int',
            'Name of the type of the value (int, str, bool) for the field in the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
            false, SdeConst::MAP_DEFAULT_TYPE);
        $this->registerArgument('table', 'string',
            'Name of the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
            false, "tt_content");
        $this->registerArgument('identname', 'string',
            'name of the identfield, which is used to specified the row in the model. It can miss, if a customized process use an self-defined get- and update-process to retrieve the data.',
            false, 'uid');

        /** Parameter defines the content */

        $this->registerArgument('paramList', 'string',
            'A list of arguments for customized parsing-processes properly in array-format. It will be convertetd to a JSON-String',
            false, "[]");

        $this->registerArgument('roles', 'string',
            'The comma-separated list of usergroups with its uid and/or its title).',
            false);

        /** the flag defines the usage of frontendediting, if nobody is loggedin into the backend */
        $this->registerArgument('always', 'bool',
            'Allow always the frontend-editing to everyone. The allowance must be freed in the extension-configuration',
            false, false);
    }

    /**
     * render only children-context or warp children-context in <simpledataedit>-tag
     *
     * @return mixed|string
     * @throws AspectNotFoundException
     */
    public function render()
    {

        $result = $this->renderChildren();
        $pageId = (int)($this->arguments['pid'] ?? 0);
        if ($this->flagCascadeForLoginAccessCheck($pageId)) {
            /** @var CustomEditorInfo $customEditorInfo */
            $customEditorInfo = $this->prepareCustomEditorInfoFromArguments($this->arguments);
            $this->prepareTagFromArguments($customEditorInfo);
            /** @var CustomEditorInterface $editor */
            $editor = $this->getEditorFromName($customEditorInfo->getEditor());
            /* add initial to allow designing - changes clear frontend-cache */
            $this->tag->addAttribute(
                'contenteditable',
                'true'
            );
            $this->tag->addAttribute(
                'data-editor',
                $editor->whoAmI()
            );
            $this->tag->addAttribute(
                'class',
                'simpledataedit ' . $editor->whoAmI()
            );


            $customEditorInfo->setRaw(
                strip_tags(
                    ($this->arguments['raw'] ?? '')
                )
            );
            $hash = $editor->generateHash($customEditorInfo);

            $this->tag->addAttribute(
                'data-hash',
                $hash
            );
            $customEditorInfo->setHash($hash);
            $content = $editor->parseRawInViewhelperPhp($customEditorInfo);

            $this->tag->addAttribute('data-content', json_encode($content));

            /** make content-element editable */
            $this->tag->addAttribute('contenteditable', 'true');

            if (empty($customEditorInfo->getMessage())) {
                $popup = '<simpledatapopup class="simpledatapopup ' . $editor->whoAmI() . '" ></simpledatapopup>' . "\n";
            } else {
                $popup = '<simpledatapopup class="simpledatapopup ' . $editor->whoAmI() . ' active" >' .
                    trim($customEditorInfo->getMessage()) . '</simpledatapopup>' . "\n";
            }
            $this->tag->setContent($result);
            $this->tag->forceClosingTag(true);
            $result = '<sdecontainer>'.$popup . $this->tag->render().'</sdecontainer>';
        }
        return $result;
    }

    /**
     * define in a return-cascade o boolean flag, which decide if the data should be wrapped by the custom element or not
     *
     * @param int $pageId
     * @return bool
     */
    protected function flagCascadeForLoginAccessCheck(int $pageId)
    {
        if ($pageId < 0) {
            throw new SimpledataeditException(
                'The page-id `' . print_r($pageId, true) . '` is not correct. ' .
                'Check the data prowvidetd for the parameter `pid`.',
                1617433101
            );
        }
        if (empty(($this->arguments['always'] ?? false))) {
            $roleList = $this->arguments['roles'] ?? '';
            $checkRec = BackendUtility::getRecord(
                'pages',
                $pageId
            );
            if (empty($roleList)) {
                return (
                    (!empty($GLOBALS['BE_USER'])) &&
                    ($GLOBALS['BE_USER']->doesUserHaveAccess($checkRec, 2) ?? false)
                );
            } else {
                $roles = array_filter(
                    array_map(
                        'trim',
                        explode(',', $roleList)
                    )
                );
                if (is_array($GLOBALS['BE_USER']->userGroups)) {
                    foreach ($GLOBALS['BE_USER']->userGroups as $userGroup) {
                        if ((in_array((int)$userGroup['uid'], $roles)) ||
                            (in_array(($userGroup['uid'] . ''), $roles)) ||
                            (in_array($userGroup['title'], $roles))
                        ) {
                            return ($GLOBALS['BE_USER']->doesUserHaveAccess($checkRec, 2) ?? false);
                        }
                    }
                }
                return false;
            }
        }
        return true;
    }

    /**
     * Extract the current class from registered frontend-Editing-classes
     *
     * @param string $editorName
     * @return CustomEditorInterface
     */
    public function getEditorFromName(string $editorName)
    {
        return GeneralUtility::makeInstance(PlainTextEditor::class);
    }

    /**
     * defines the CustomEditorInfo-object for the used editor-class
     *
     * @return CustomEditorInfo
     */
    protected function prepareCustomEditorInfoFromArguments(array $arguments): CustomEditorInfo
    {
        return CustomEditorInfoUtility::prepareCustomEditorInfoFromArgumentList($arguments);
    }

    /**
     * defines the data-attributes of the editable tag by using thje CustomEditorInfo-object
     *
     */
    protected function prepareTagFromArguments($customEditorInfo): void
    {
        $this->tag->addAttribute('data-editor', $customEditorInfo->getEditor());
        $this->tag->addAttribute('data-pid', $customEditorInfo->getPid());
        $this->tag->addAttribute('data-fieldname', $customEditorInfo->getFieldname());
        $this->tag->addAttribute('data-uid', $customEditorInfo->getUid());
        $this->tag->addAttribute('data-type', $customEditorInfo->getType());
        $this->tag->addAttribute('data-table', $customEditorInfo->getTable());
        $this->tag->addAttribute('data-identname', $customEditorInfo->getIdentname());
        $this->tag->addAttribute('data-params', $customEditorInfo->getParams());
    }

}
