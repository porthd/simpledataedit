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

use Exception;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\EditorArgumentsInterface;
use Porthd\Simpledataedit\Domain\Model\Arguments\Interfaces\RelatedArgumentsInterface;
use Porthd\Simpledataedit\Exception\SimpledataeditException;

/**
 * Class EditorArguments contains some date, which are needed for the update of single fields
 * and which are posted via the viewhelper.
 *
 */
class EditorArguments implements EditorArgumentsInterface
{
    use DataArguments;
    use DiversArguments;
    use FrontendArguments;
    use HelperArguments;
    use InterRelatedArguments;
    use LangDataArguments;
    use LangRelatedArguments;
    use NamingArguments;
    use RelatedArguments;

    /**
     * Internal variable for message in the pop-windows
     *
     * @var string
     */
    protected $message = '';


    /**
     * the methods helps to define a full set of variable for the viewhelper
     * Each editor must define, which variables are really needed
     *
     * @return array[]
     */
    public function getInitViewhelperParameter():array
    {
        return array_merge(
            $this->getInitViewhelperParameterForDataArguments(),
            $this->getInitViewhelperParameterForDiversArguments(),
            $this->getInitViewhelperParameterForFrontendArguments(),
            $this->getInitViewhelperParameterForHelperArguments(),
            $this->getInitViewhelperParameterForInterRelatedArguments(),
            $this->getInitViewhelperParameterForLangDataArguments(),
            $this->getInitViewhelperParameterForLangRelatedArguments(),
            $this->getInitViewhelperParameterForNamingArguments(),
            $this->getInitViewhelperParameterForRelatedArguments(),

        );
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }


}