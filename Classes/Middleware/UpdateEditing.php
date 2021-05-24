<?php

namespace Porthd\Simpledataedit\Middleware;

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
use Porthd\Simpledataedit\Config\SdeConst;
use Porthd\Simpledataedit\Domain\Model\NeededTagArgs;
use Porthd\Simpledataedit\Domain\Repository\GeneralRepository;
use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\EditorArgumentsInterface;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;
use Porthd\Simpledataedit\Services\ListOfEditorService;
use Porthd\Simpledataedit\Utilities\CustomEditorInfoUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\CacheService;

/**
 * Class UpdateEditing fish the frontend-editing request and update the fields.
 * (one Problem are the caching of content-element, which are not part of the currently rendered page.
 */
class UpdateEditing implements MiddlewareInterface
{
    protected const LENGTH_HASH_BY_MD5 = 32;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('normalizedParams')->getRequestUri() === SdeConst::PATH_FOR_UPDATE_MIDDLE) {
            try {
                $generalRepository = GeneralUtility::makeInstance(GeneralRepository::class);

                $jsonArgs = json_decode(file_get_contents('php://input'), true);
                /** @var CustomEditorInterface $editor */
                if (($editorName = ($jsonArgs[NeededTagArgs::TAG_ATTR_DATA_EDITOR] ?? '')) !== '') {
                    $hash = $jsonArgs[NeededTagArgs::TAG_ATTR_HASH_EDIT];
                    $flagChange = false;
                    $flagMade = false;
                    $editorList = GeneralUtility::makeInstance(ListOfEditorService::class);
                    /** @var CustomEditorInterface $editorObj */
                    $editorObj = $editorList->getItemClass($editorName);

                    /** @var EditorArgumentsInterface $editorArguments */
                    $editorArguments = CustomEditorInfoUtility::fillEditorArgumentsFromArgumentList($jsonArgs,$editorObj);
                    $checkHash = $editorObj->generateHash(
                        $editorArguments,
                        json_decode($jsonArgs[NeededTagArgs::TAG_ATTR_JSONRAWCONTENT])
                    );
                    $flagEditor = ($editorObj !== null);
                    if (
                        ($flagEditor) &&

                        (strlen($hash) === self::LENGTH_HASH_BY_MD5)
                    ) {

                        $data = $editorObj->parseUpdateFlowPhp($editorArguments->getJsonRaw(), $editorArguments);
                        if (($ownMethod = $editorObj->getNameOfDataRequestMethod($editorArguments)) === false) {
                            $oldData = $generalRepository->getSingelData($editorArguments);
                        } else {
                            $oldData = $editorObj->$ownMethod($editorArguments);
                        }
                        $flag = false;
                        $flagType = 0;
                        if (($checkHash === $editorObj->generateHash($editorArguments, $oldData)) &&
                            ($flagChange = ($data !== $oldData))
                        ) {
                            if (($customUpdate = $editorObj->getNameOfDataUpdateMethod($editorArguments)) === false) {
                                $doType = $editorObj->getTypeOfDataUpdateMethod($editorArguments);
                                switch ($doType) {
                                    case 'makeContent':
                                    case 'makeData':
                                    case 'makeChild':
                                    case 'makeProgenitor':
                                    case 'makePeer':
                                        $flagType = 'made';
                                        $reposioryTypeMethod = lcfirst($doType).'OnDatabase';
                                        $flag = $generalRepository->$reposioryTypeMethod(
                                            $editorArguments,
                                            $data
                                        );
                                        break;
                                    case 'removeContent':
                                    case 'removeData':
                                    case 'removeChild':
                                    case 'removeProgenitor':
                                    case 'removePeer':
                                        $flagType = 'remove';
                                        $reposioryTypeMethod = lcfirst($doType).'OnDatabase';
                                        $flag = $generalRepository->$reposioryTypeMethod(
                                            $editorArguments
                                        );
                                        break;
                                    default : {
                                        $flagType = 'edit';
                                        $flag = $generalRepository->updateDataOnDatabase(
                                            $editorArguments,
                                            $data
                                        );
                                        break;
                                    }
                                }
                            } else {
                                $flag = $editorObj->$customUpdate($data, $editorArguments);
                            }
                            /** @var CacheService $cacheService */
                            $cacheService = GeneralUtility::makeInstance(CacheService::class);
                            $cacheService->clearPageCache($editorArguments->getStoragePid());
                        }
                    }

                    $responseFactory = GeneralUtility::makeInstance(ResponseFactory::class);
                    $response = $responseFactory->createResponse();
                    if ($flag) {
                        switch($flagType)
                        {
                            case 'made':
                                break;
                            case 'remove':
                                $response->withStatus(200, 'Content-editing is remove.')
                                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
                                $response->getBody()->write(
                                    json_encode([
                                        'status' => 'ok',
                                        'hash' => $editorArguments->getHash(),
                                    ])
                                );
                                break;
                            default :
                                $response->withStatus(200, 'Content-editing is updated.')
                                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
                                $response->getBody()->write(
                                    json_encode([
                                        'status' => 'ok',
                                        'hash' => $editorArguments->getHash(),
                                    ])
                                );
                        }
                        return $response;
                    } else {
                        if (!$flagChange) {
                            $response->withStatus(204, 'No edited content - Content unchanged.');
                            $response->getBody()->write(
                                json_encode([
                                    'status' => 'ok',
                                    'hash' => $editorArguments->getHash(),
                                ])
                            );
                            return $response;
                        } else if ($flagMade) {
                            $response->withStatus(200, 'Content-editing is updated.')
                                ->withHeader('Content-Type', 'application/json; charset=utf-8');
                            $response->getBody()->write(
                                json_encode([
                                    'status' => 'ok',
                                    'hash' => $editorArguments->getHash(),
                                ])
                            );

                        }
                    }
                }
                $response->withStatus(500,
                    'The content could not be updated. Perhaps the hash of the changed content is outdated.' .
                    ' Please relaod your page.'
                );
                return $response;
            } catch (Exception $e) {
                $response->withStatus(500, 'There occured an exception for the frontendediting ' .
                    'with the following parameter: ' . "\n" . print_r($jsonArgs, true));
                return $response;
            }
        }
        return $handler->handle($request);
    }

}