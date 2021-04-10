<?php

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
$EM_CONF[$_EXTKEY] = [
    'title' => 'simple data edit / simple frontend-editing ',
    'description' => 'General frontend_editing with TYPO3',
    'category' => 'extension',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.1-10.4.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Porthd\\Simpledataedit\\' => 'Classes',
        ],
    ],
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Dr. Dieter Porth',
    'author_email' => 'info@mobger.de',
    'author_company' => 'Private',
    'version' => '10.1.1',
];
