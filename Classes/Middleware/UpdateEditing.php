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
use Porthd\Simpledataedit\Domain\Repository\GeneralRepository;
use Porthd\Simpledataedit\Editor\CustomEditorInterface;
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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('normalizedParams')->getRequestUri() === SdeConst::PATH_FOR_UPDATE_MIDDLE) {
            try {
                $generalRepository = GeneralUtility::makeInstance(GeneralRepository::class);

                $jsonArgs = json_decode(file_get_contents('php://input'), true);
                /** @var CustomEditorInterface $editor */
                if (($editor = ($jsonArgs['editor'] ?? '')) !== '') {
                    $flagChange = false;
                    $editorList = GeneralUtility::makeInstance(ListOfEditorService::class);
                    /** @var CustomEditorInterface $editor */
                    $editor = $editorList->getItemClass($editor);
                    $customEditorInfo = CustomEditorInfoUtility::prepareCustomEditorInfoFromArgumentList($jsonArgs);
                    $customEditorInfo->setRaw(trim(($jsonArgs['raw'] ?? '')));
                    $customEditorInfo->setUntrimmedRaw(($jsonArgs['raw'] ?? ''));

                    $customEditorInfo->setHash(
                        $editor->generateHash($customEditorInfo)
                    );
                    $checkHash =                         $editor->generateHash(
                        $customEditorInfo,
                        json_decode($jsonArgs['content'])
                    );
                    if (
                        ($flag = ($editor !== null)) &&
                        ($customEditorInfo->getRaw() !== false) &&
                        (($jsonArgs['hash'] ?? $customEditorInfo->getHash()) !== false)
                    ) {

                        $data = $editor->parseUpdateFlowPhp($customEditorInfo->getRaw(), $customEditorInfo);
                        if (($ownMethod = $editor->getNameOfDataRequestMethod($customEditorInfo)) === false) {
                            $oldData = $generalRepository->getSingelData($customEditorInfo);
                        } else {
                            $oldData = $editor->$ownMethod($customEditorInfo);
                        }
                        $flag = false;
                        if (($checkHash === $editor->generateHash($customEditorInfo, $oldData)) &&
                            ($flagChange = ($data !== $oldData))
                        ) {
                            if (($customUpdate = $editor->getNameOfDataUpdateMethod($customEditorInfo)) === false) {
                                $flag = $generalRepository->updateDataOnDatabase(
                                    $customEditorInfo,
                                    $data
                                );
                            } else {
                                $flag = $editor->$customUpdate($data, $customEditorInfo);
                            }
                            /** @var CacheService $cacheService */
                            $cacheService = GeneralUtility::makeInstance(CacheService::class);
                            $cacheService->clearPageCache($customEditorInfo->getPid());
                        }
                    }

                    $responseFactory = GeneralUtility::makeInstance(ResponseFactory::class);
                    $response = $responseFactory->createResponse();
                    if ($flag) {
                        $response->withStatus(200, 'Content-editing is updated.')
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
                        $response->getBody()->write(
                            json_encode([
                                'status' => 'ok',
                                'hash' => $customEditorInfo->getHash(),
                            ])
                        );
                        return $response;
                    } else {
                        if (!$flagChange) {
                            $response->withStatus(204, 'No edited content - Content unchanged.');
                            $response->getBody()->write(
                                json_encode([
                                    'status' => 'ok',
                                    'hash' => $customEditorInfo->getHash(),
                                ])
                            );
                            return $response;
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