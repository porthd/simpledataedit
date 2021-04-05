<?php

namespace Porthd\Simpledataedit\Middleware;

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

use Exception;
use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Exception\SimpledataeditException;
use Porthd\Simpledataedit\Services\ListOfEditorService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Class ResourcesForFrontendEditing
 * This extension add some needed styles and javascript-codes to the rendered page
 */
class ResourcesForFrontendEditing implements MiddlewareInterface
{
// inlinejavascript
    private const INITIAL_JAVASCRIPT_INLINE_CODE_INIT = '"use strict"' . "\n";
    private const INITIAL_JAVASCRIPT_INLINE_CODE_START = <<<EOD
if (typeof PorthdSimpledataedit === 'undefined') {
    var PorthdSimpledataedit = {};
}

PorthdSimpledataedit = {
    ...PorthdSimpledataedit,
    focusin: {
EOD;
    private const INITIAL_JAVASCRIPT_INLINE_CODE_MIDDLE = <<<EOD
    },
    focusout: {   
EOD;

    private const INITIAL_JAVASCRIPT_INLINE_CODE_END = <<<EOD
    }
}    
EOD. '
PorthdSimpledataedit.pathForSimpledataeditUpdate = "' . SdeConst::PATH_FOR_UPDATE_MIDDLE . '";';

    private const INITIAL_JAVASCRIPT_INLINE_CODE_TEST = <<<EOD

/** Check working code */
console.log('all works fine. Current state of global variable `PorthdSimpledataedit`');
console.log(PorthdSimpledataedit);

EOD;

    /** @var PageRenderer */
    protected $pageRender;

    protected $flags = [
        'compress' => true,
        'exclude' => true,
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $extensionConfig = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('simpledataedit');

        if ((!empty($GLOBALS['BE_USER'])) ||
            (!empty($extensionConfig['flagAllowAlways']))
        ) {
            $this->addaptForDevelopmentContext();

            $this->pageRender = GeneralUtility::makeInstance(PageRenderer::class);
            $this->addDynamicJavascript($extensionConfig); // javascript in Head
            $this->addBasicFooterJavascript($extensionConfig); //
            $this->addBasicStylesheet($extensionConfig);
        }
        return $handler->handle($request);
    }

    /**
     * @return string
     * @throws SimpledataeditException
     */
    protected function generateInlineJavaScript(): string
    {
        $inlineCode = '';
        /** @var ListOfEditorService $editorList */
        $editorList = GeneralUtility::makeInstance(ListOfEditorService::class);
        if ($editorList->goFirst()) {
            $focusInCode = '';
            $focusOutCode = '';
            do {
                $focusInCode .= $editorList->getCurrentClass()->parseJsFocusinContentToInnerHtml() . "\n";
                $focusOutCode .= $editorList->getCurrentClass()->parseJsFocusoutInnerHtmlToContent() . "\n";
            } while ($editorList->goNext());
            $inlineCode .= self::INITIAL_JAVASCRIPT_INLINE_CODE_INIT;
            $inlineCode .= self::INITIAL_JAVASCRIPT_INLINE_CODE_START;
            $inlineCode .= $focusInCode;
            $inlineCode .= self::INITIAL_JAVASCRIPT_INLINE_CODE_MIDDLE;
            $inlineCode .= $focusOutCode;
            $inlineCode .= self::INITIAL_JAVASCRIPT_INLINE_CODE_END;
            $currentApplicationContext = Environment::getContext();
            if (strpos(strtolower($currentApplicationContext), 'development') === 0) {

                $inlineCode .= self::INITIAL_JAVASCRIPT_INLINE_CODE_TEST;
            }
        }
        return $inlineCode;
    }

    /**
     * @param array $extensionConfig
     */
    protected function addBasicFooterJavascript(array $extensionConfig): void
    {
        if (!empty($extensionConfig[SdeConst::KEY_STATIC_TEMP_JSLIB])) {
            $source = GeneralUtility::getFileAbsFileName($extensionConfig[SdeConst::KEY_STATIC_TEMP_JSLIB]);
            $source = PathUtility::getAbsoluteWebPath($source);
            $this->pageRender->addJsFooterFile(
                $source,
                'text/javascript', $this->flags['compress'], false,
                '', $this->flags['exclude'], true);
        }
    }

    /**
     * @param array $extensionConfig
     * @throws SimpledataeditException
     */
    protected function addDynamicJavascript(array $extensionConfig): void
    {
        $inlineJavaScript = $this->generateInlineJavaScript();
        if (!empty($extensionConfig[SdeConst::KEY_STATIC_TEMP_JSDYNAMIC])) {
            $source = GeneralUtility::getFileAbsFileName($extensionConfig[SdeConst::KEY_STATIC_TEMP_JSDYNAMIC]);
            if ((!file_exists($source)) ||
                (hash_file("md5", $source) !== md5($inlineJavaScript))
            ) {
                try {
                    file_put_contents($source, $inlineJavaScript);
                } catch (Exception $e) {
                    throw new SimpledataeditException(
                        'You may not have the permission to override the following file:' . $source . "\n" .
                        'you get the following message: `' . $e->getMessage() . '`.',
                    );
                }
            }
            $source = PathUtility::getAbsoluteWebPath($source);
            $this->pageRender->addJsFile(
                $source,
                'text/javascript', $this->flags['compress'], false, '', $this->flags['exclude']
            );
        } else {
            // It may not wörk korrektly, if your page-security don't allow the usage of inline-code for javascript
            $this->pageRender->addJsInlineCode(
                'simpledataeditJavaScriptDynamicInline',
                $inlineJavaScript, $this->flags['compress'], false
            );
        }
    }

    /**
     * @param array $extensionConfig
     */
    protected function addBasicStylesheet(array $extensionConfig): void
    {
        if (!empty($extensionConfig[SdeConst::KEY_STATIC_TEMP_CSS])) {
            $source = $extensionConfig[SdeConst::KEY_STATIC_TEMP_CSS];
            if (strpos($source, SdeConst::KEY_STATIC_EXTENSIONPATH) === 0 || strpos($source, '/') !== 0) {
                $source = GeneralUtility::getFileAbsFileName($source);
            }
            $source = PathUtility::getAbsoluteWebPath($source);
            $this->pageRender->addCssLibrary(
                $source,
                'stylesheet', '', '', $this->flags['compress'], false,
                '', $this->flags['exclude']);
        }
    }

    protected function addaptForDevelopmentContext(): void
    {
        $currentApplicationContext = Environment::getContext();
        if (strpos(strtolower($currentApplicationContext), 'development') === 0) {
            $this->flags = [
                'compress' => false,
                'exclude' => true,
            ];
        }
    }

}