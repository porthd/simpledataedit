<?php

namespace Porthd\Simpledataedit\Cache;


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


use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\EditorArgumentsInterface;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\SingletonInterface;

class ConfigSaveCache implements SingletonInterface
{
    protected const LIFETIME_CACHE_FRONTENDEDITING = 86400; // one day

    /**
     * @var FrontendInterface
     */
    private $cache;

    public function __construct(FrontendInterface $cache)
    {
        $this->cache = $cache;
    }

    public function setCachedValues(EditorArgumentsInterface $customEditorInfo, $type): string
    {
        $customEditorInfo->makeAttributesHash($type);
        $attributesHash = $customEditorInfo->getAttributesHash();
        $this->cache->set($attributesHash, $customEditorInfo, [$type], self::LIFETIME_CACHE_FRONTENDEDITING);
        return $attributesHash;
    }

    protected function getCachedValue($cacheIdentifier)
    {
//        $cacheIdentifier = /* ... logic to determine the cache identifier ... */;

//// If $entry is false, it hasn't been cached. Calculate the value and store it in the cache:
        if (($value = $this->cache->get($cacheIdentifier)) === false) {
//            $value = /* ... Logic to calculate value ... */;
//            $tags = /* ... Tags for the cache entry ... */
//            $lifetime = /* ... Calculate/Define cache entry lifetime ... */
//
//// Save value in cache
//                $this->cache->set($cacheIdentifier, $value, $tags, $lifetime);
        }

        return $value;
    }
}