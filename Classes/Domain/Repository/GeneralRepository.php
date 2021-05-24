<?php

namespace Porthd\Simpledataedit\Domain\Repository;


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


use PDO;

use Porthd\Simpledataedit\Domain\Model\Arguments\EditorArguments;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository contains general methods for request to single datafields
 */
class GeneralRepository
{

    /**
     * @param EditorArguments $editorArguments
     * @return mixed
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function getSingelData(EditorArguments $editorArguments)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(
                $editorArguments->getTable()
            );

        $queryBuilder->select(
            $editorArguments->getFieldName() // will be quoted
        )->from(
            $editorArguments->getTable() // will be quoted
        )->where(
            $queryBuilder->expr()->eq(
                $editorArguments->getIdentField(), // Will be quoted
                $queryBuilder->createNamedParameter(
                    $editorArguments->getIUid(),
                    \PDO::PARAM_INT
                )
            )
        );
        return $queryBuilder->execute()->fetchColumn(0);
    }

    /**
     * @param EditorArguments $editorArguments
     * @param string|int|float|bool $data
     * @param int $type
     * @return \Doctrine\DBAL\Driver\Statement|int
     */
    public function updateDataOnDatabase(EditorArguments $editorArguments, $data)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(
                $editorArguments->getTable()
            );

        $queryBuilder->update(
            $editorArguments->getTable() // will be quoted
        )->set(
            $editorArguments->getFieldName(), // will be quoted
            $data
        )->where(
            $queryBuilder->expr()->eq(
                $editorArguments->getIdentField(),
                $queryBuilder->createNamedParameter(
                    $editorArguments->getIdentValue(),
                    PDO::PARAM_INT
                )
            )
        );
        return $queryBuilder->execute();
    }

    public function makeContentOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function makeDataOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function makeChildOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function makeProgenitorOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function makePeerOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function removeContentOnDatabase(EditorArguments $editorArguments)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(
                $editorArguments->getTable()
            );

        $queryBuilder->delete(
            $editorArguments->getTable() // will be quoted
        )->where(
            $queryBuilder->expr()->eq(
                $editorArguments->getIdentField(),
                $queryBuilder->createNamedParameter(
                    $editorArguments->getIdentValue(),
                    PDO::PARAM_INT
                )
            )
        );
        return $queryBuilder->execute();

    }

    public function removeDataOnDatabase(EditorArguments $editorArguments)
    {
        $this->removeContentOnDatabase($editorArguments);
    }

    public function removeChildOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function removeProgenitorOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

    public function removePeerOnDatabase(EditorArguments $editorArguments, $data)
    {

    }

}
