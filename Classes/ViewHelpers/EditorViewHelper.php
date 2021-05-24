<?php

namespace Porthd\Simpledataedit\ViewHelpers;

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

use Exception;
use Porthd\Simpledataedit\Cache\ConfigSaveCache;
use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Domain\Model\Arguments\DiversArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\InterRelatedArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\LangDataArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\LangRelatedArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\NamingArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
use Porthd\Simpledataedit\Domain\Model\NeededTagArgs;
use Porthd\Simpledataedit\Editor\Methods\PlainTextEditor;
use Porthd\Simpledataedit\Exception\SimpledataeditException;
use Porthd\Simpledataedit\Utilities\CustomEditorInfoUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
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
        /** The parameter related to different models. The parameter are define in the models  */
        /** Parameter defines update-Process in direction to the database */
        $classList = $this->getClassList();
        foreach ($classList as $className) {
            if (isset($className::INIT_VIEWHELPER_PARAMETER)) {
                $list = $className::INIT_VIEWHELPER_PARAMETER;
                foreach ($list as $entry) {
                    if ($entry['flagRequired']) {
                        $this->registerArgument(
                            $entry['name'],
                            $entry['type'],
                            $entry['description'],
                            $entry['flagRequired']
                        );
                    } else {
                        $this->registerArgument(
                            $entry['name'],
                            $entry['type'],
                            $entry['description'],
                            $entry['flagRequired'],
                            $entry['default']
                        );
                    }
                }
            }
        }
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
        $pageId = (int)($this->arguments[NeededTagArgs::CHECK_USERROLE_FOR_STORAGE_PID] ?? 0);
        $editorName = $this->getCurrentEditor();
        if ($this->flagCascadeForLoginAccessCheck($pageId)) {
            /** @var CustomEditorInterface $editor */
            $editor = $this->getEditorFromName($editorName);
            // @Todo add a caching for the viewhelper
            /** @var NeededTagArgs $paramEditorCheckList */
            $paramEditorCheckList = GeneralUtility::makeInstance(NeededTagArgs::class);
            $paramEditorCheckList->setEditor($editor);
            // Clone the needed and optional attributes into the Args-Object `$customEditorInfo`
            /** @var EditorArguments $customEditorInfo */
            $customEditorInfo = $this->prepareEditorArgumentsFromArguments(
                $editor,
                $paramEditorCheckList,
                $this->arguments
            );
            // Generate the hash by the Arguments
            $hash = $editor->generateHash($customEditorInfo);
            $customEditorInfo->setHash($hash);
            $customEditorInfo->putInListOfJsonValues(
                NeededTagArgs::TAG_ATTR_HASH_EDIT,
                json_encode($hash));

            // all values must be set in `$customEditorInfo`
            $this->prepareTagFromArguments($customEditorInfo, $paramEditorCheckList, $editor);

            // add initial to allow designing - changes clear frontend-cache
            $this->tag->addAttribute(
                'contenteditable',
                'true'
            );
            $classAdd = trim(
                ($this->tag->getAttribute('class') ?? '') .
                ' simpledataedit-' . $editor::whoAmI()
            );
            $this->tag->addAttribute('class', $classAdd);


            if (empty($customEditorInfo->getMessage())) {
                $popup = '<simpledatapopup class="simpledatapopup ' . $editor::whoAmI() . '" ></simpledatapopup>' . "\n";
            } else {
                $popup = '<simpledatapopup class="simpledatapopup ' . $editor::whoAmI() . ' active" >' .
                    trim($customEditorInfo->getMessage()) . '</simpledatapopup>' . "\n";
            }
            $this->tag->setContent($result);
            $this->tag->forceClosingTag(true);
            $result = '<sdecontainer>' . $popup . $this->tag->render() . '</sdecontainer>';
        }
        return $result;
    }

    /**
     * define in a return-cascade o boolean flag, which decide if the data should be wrapped by the custom element or not
     *
     * @param int $pageId
     * @return bool
     */
    protected function flagCascadeForLoginAccessCheck(int $pageId): bool
    {
        if ($pageId < 0) {
            throw new SimpledataeditException(
                'The page-id `' . print_r($pageId, true) . '` is not correct. ' .
                'Check the data prowvidetd for the parameter `pid`.',
                1617433101
            );
        }
        $flag = true;
        if (empty(($this->arguments['always'] ?? false))) {
            $roleList = $this->arguments['roles'] ?? '';
            $checkRec = BackendUtility::getRecord(
                'pages',
                $pageId
            );
            if (empty($roleList)) {
                $flag = (
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
                $flag = false;
            }
        }
        return $flag;
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
     * defines the EditorArguments-object for the used editor-class, which is defined in Checklist.
     * The named elements in the  checklist are transfered to Objekt of the EditorArguments. All other field will have their default-value
     * The elements are gotten from different places/repositories
     * => Editor-default, YAML-file, JSON in Attribute, FluidArray in atribute, named Attributes
     *
     * @param CustomEditorInterface $editor
     * @param NeededTagArgs $checkList
     * @param array $arguments
     * @return EditorArguments
     * @throws SimpledataeditException
     */
    protected function prepareEditorArgumentsFromArguments(
        CustomEditorInterface $editor,
        NeededTagArgs $checkList,
        array $arguments
    ): EditorArguments {
        $genericArguments = $this->getPredifinedAttributes($editor, $arguments);
        return $this->overrideListByAttributeFromViewhelper($editor, $genericArguments, $arguments, $checkList);
    }

    /**
     * defines the data-attributes of the editable tag by using thje EditorArguments-object
     *
     * @param EditorArguments $customEditorInfo
     * @param NeededTagArgs $paramEditorCheckList
     * @param CustomEditorInterface $editor
     * @throws SimpledataeditException
     */
    protected function prepareTagFromArguments(
        EditorArguments $customEditorInfo,
        NeededTagArgs $paramEditorCheckList,
        CustomEditorInterface $editor
    ): void {
        if ($customEditorInfo->isFlagDebug()) {
            try {
                CustomEditorInfoUtility::fillTagBuilderFromAttributeList(
                    $this->tag,
                    $customEditorInfo,
                    $paramEditorCheckList,
                    CustomEditorInterface::TYPE_ATTRIBUTES_EDIT
                );
            } catch (Exception $e) {
                throw new SimpledataeditException(
                    'The ist an exception thrown while adding the tags for the webcomponent. ' .
                    'Perhaps the getter of `editor` or `hash` are missing. I got the following exception-message:' . "\n" .
                    $e->getMessage(),
                    1621070251
                );

            }
        } else {
            // Define the caching of customEditorInfos
            /** @var ConfigSaveCache $cache */
            $cache = GeneralUtility::makeInstance(ConfigSaveCache::class);
            $attributesHash = $cache->setCachedValues($customEditorInfo, CustomEditorInterface::TYPE_ATTRIBUTES_EDIT);
            $this->tag->addAttribute(
                NeededTagArgs::TAG_ATTR_attributesHash_CACHE,
                $attributesHash
            );
        }
    }

    /** get the parts of the variable needed in some sitiuations of frontend-editing */
    protected function getClassList()
    {
        return [
            DiversArguments::class,
            InterRelatedArguments::class,
            LangDataArguments::class, // contain DataArguments::class
            LangRelatedArguments::class, // contain RelatedArguments::class
            NamingArguments::class,
        ];
    }

    /**
     * @return string
     * @throws SimpledataeditException
     */
    protected function getCurrentEditor(): string
    {
        if (empty($this->arguments['editor'])) {
            throw new SimpledataeditException(
                'The parameter argument `editor` is missing.Please check the definition of the viewhelper in your template.',
                1621069621
            );
        }
        return trim($this->arguments['editor']);
    }

    /**
     * @param array $arguments
     * @return array
     */
    protected function getJsonData(array $arguments): array
    {
        return ((!empty($arguments[NeededTagArgs::TAG_ATTR_JSON_DATA])) ?
            json_decode($arguments[NeededTagArgs::TAG_ATTR_JSON_DATA], true) :
            []
        );
    }

    /**
     * @param array $arguments
     * @return array
     * @throws SimpledataeditException
     */
    protected function getYamlDataPath(array $arguments): array
    {
        if (!empty($arguments[NeededTagArgs::TAG_ATTR_YAML_DATA])) {
            if (!is_string($arguments[NeededTagArgs::TAG_ATTR_YAML_DATA])) {
                throw new SimpledataeditException(
                    'Please check your editor-viewhelper. ' . ' `' . NeededTagArgs::TAG_ATTR_YAML_DATA .
                    '` contains not a string with the path to the yaml-file: ' . "\n" .
                    print_r($arguments[NeededTagArgs::TAG_ATTR_YAML_DATA], true),
                    1621072181
                );

            }
            $yamlLoader = GeneralUtility::makeInstance(YamlFileLoader::class);
            return $yamlLoader->load($arguments[NeededTagArgs::TAG_ATTR_YAML_DATA]);
        }
        return [];
    }

    /**
     * @param CustomEditorInterface $editor
     * @param $yamlDataPath
     * @return array
     */
    protected function getDefaultYaml(CustomEditorInterface $editor): array
    {
        $defaultPath = $editor->getDefaultYamlPath();
        if (!empty($defaultPath)) {
            /** @var YamlFileLoader $yamlLoader */
            $yamlLoader = GeneralUtility::makeInstance(YamlFileLoader::class);
            $result = $yamlLoader->load($defaultPath);
            // in this way of definition, you can add more definitions in the same file, if you wish that
            if (!empty($result[SdeConst::YAML_MAIN_START][$editor::whoAmI()])){
                return $result[SdeConst::YAML_MAIN_START][$editor::whoAmI()];
            }
        }
        return [];
    }

    /**
     * @param array $arguments
     * @return array[]
     * @throws SimpledataeditException
     */
    protected function getFluidData(array $arguments): array
    {
        if (!empty($arguments[NeededTagArgs::TAG_ATTR_FLUID_DATA])) {
            if (!is_array($arguments[NeededTagArgs::TAG_ATTR_FLUID_DATA])) {
                throw new SimpledataeditException(
                    'Please check your editor-viewhelper. ' . ' `fluidData` contains not an array: ' . "\n" .
                    print_r($arguments['fluidData'], true),
                    1621072181
                );
            }
            return $arguments['fluidData'];
        }
        return [];
    }

    /**
     * @param CustomEditorInterface $editor
     * @param array $arguments
     * @param array $attrList
     * @param object $checkList
     * @return EditorArguments
     * @throws SimpledataeditException
     */
    protected function overrideListByAttributeFromViewhelper(
        CustomEditorInterface $editor,
        array $genericArguments,
        array $arguments,
        NeededTagArgs $checkList
    ): EditorArguments {
        /** @var EditorArguments $args */
        $args = GeneralUtility::makeInstance(EditorArguments::class);
        try {
            foreach (
                $checkList->getAttributeList(CustomEditorInterface::TYPE_ATTRIBUTES_EDIT) as $attrName
            ) {
                $getter = 'get' . ucfirst($attrName);
                $setter = 'set' . ucfirst($attrName);
                /**
                 * programm the overriding of values in the cascade ( higher is better)
                 * 0 Default-Getter-value
                 * 1 Merge from YAML, JSON, fluid
                 * 2 merged from direct Arguments $defaultList, $yamlList, $jsonList, $fluidList
                 *   a) default yaml-list of viewhelper ($editor::getDefaultYamlPath();>)
                 *   b) yaml-list by editor-attribute ($arguments[NeededTagArgs::TAG_ATTR_FLUID_DATA])
                 *   c) json-String in editor-attribute ($arguments[NeededTagArgs::TAG_ATTR_YAML_DATA])
                 *   d) fluid-list by  ($arguments[NeededTagArgs::TAG_ATTR_JSON_DATA])
                 * 3 gotten by direct viewhelper-attribute
                 */
                $value = $genericArguments[$attrName] ?? $args->$getter();
                $value = $arguments[$attrName] ?? $value;
                $args->$setter($value);
                $args->putInListOfJsonValues(
                    $attrName,
                    json_encode($value)
                );
            }
        } catch (Exception $e) {
            throw new SimpledataeditException(
                'The list of Attributes is empty or the lately used setter `' . $setter . '` is undefined. ' .
                'Please check your attributes defined for the editor `' . $editor::whoAmI() . '` by yaml, JSON or editorlist. ' .
                'The current exception-message was: ' . "\n" . $e->getMessage(),
                1621072367
            );

        }

        return $args;
    }

    /**
     * @param CustomEditorInterface $editor
     * @param array $arguments
     * @return array|array[]
     * @throws SimpledataeditException
     */
    protected function getPredifinedAttributes(CustomEditorInterface $editor, array $arguments): array
    {
        try {
            $defaultList = $this->getDefaultYaml($editor);
            $yamlList = $this->getYamlDataPath($arguments);
            $jsonList = $this->getJsonData($arguments);
            $fluidList = $this->getFluidData($arguments);
            $genericArguments = array_merge($defaultList, $yamlList, $jsonList, $fluidList);
        } catch (Exception $e) {
            throw new SimpledataeditException(
                'The reading of parameters failed. Please check the definition of the editor-viewhelper. ' .
                'Some code throw the following-exception: ' . $e->getMessage() . "\n" . 'it contains the parameter ' . "\n" .
                print_r($defaultList, true) . "\n" .
                print_r($yamlList, true) . "\n" .
                print_r($jsonList, true) . "\n" .
                print_r($fluidList, true) . "\n",
                1621072192
            );
        }
        return $genericArguments;
    }


}
