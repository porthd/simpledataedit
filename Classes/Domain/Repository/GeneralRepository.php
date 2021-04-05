<?php

namespace Porthd\Simpledataedit\Domain\Repository;


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


use PDO;
use Porthd\Simpledataedit\Editor\CustomEditorInfo;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository contains general methods for request to single datafields
 */
class GeneralRepository
{

    /**
     * @param CustomEditorInfo $customEditorInfo
     * @return mixed
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function getSingelData(CustomEditorInfo $customEditorInfo)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(
                $customEditorInfo->getTable()
            );

        $queryBuilder->select(
            $customEditorInfo->getFieldname() // will be quoted
        )->from(
            $customEditorInfo->getTable() // will be quoted
        )->where(
            $queryBuilder->expr()->eq(
                $customEditorInfo->getIdentname(), // Will be quoted
                $queryBuilder->createNamedParameter(
                    $customEditorInfo->getUid(),
                    \PDO::PARAM_INT
                )
            )
        );
        return $queryBuilder->execute()->fetchColumn(0);
    }

    /**
     * @param CustomEditorInfo $customEditorInfo
     * @param string|int|float|bool $data
     * @param int $type
     * @return \Doctrine\DBAL\Driver\Statement|int
     */
    public function updateDataOnDatabase(CustomEditorInfo $customEditorInfo, $data)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(
                $customEditorInfo->getTable()
            );

        $queryBuilder->update(
            $customEditorInfo->getTable() // will be quoted
        )->set(
            $customEditorInfo->getFieldname(), // will be quoted
            $data
        )->where(
            $queryBuilder->expr()->eq(
                $customEditorInfo->getIdentname(),
                $queryBuilder->createNamedParameter(
                    $customEditorInfo->getUid(),
                    PDO::PARAM_INT
                )
            )
        );
        return $queryBuilder->execute();
    }

}
