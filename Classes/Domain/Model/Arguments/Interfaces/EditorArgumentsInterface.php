<?php

namespace Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces;

use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\DiversArgumentsInterface;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\InterRelatedArgumentsInterface;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\LangDataArgumentsInterface;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\LangRelatedArgumentsInterface;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\NamingArgumentsInterface;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\FrontendArgumentsInterface;

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

/**
 * Class EditorArguments contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
interface EditorArgumentsInterface extends
    DataArgumentsInterface,
    DiversArgumentsInterface,
    FrontendArgumentsInterface,
    HelperArgumentsInterface,
    InterRelatedArgumentsInterface,
    LangDataArgumentsInterface,
    LangRelatedArgumentsInterface,
    NamingArgumentsInterface,
    RelatedArgumentsInterface
{

    /**
     * @return array[]
     */
    public function getInitViewhelperParameter():array;


}