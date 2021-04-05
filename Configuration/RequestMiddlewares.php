<?php

return [
    'frontend' => [
        'porthd/simpledataedit/updateediting' => [
            'target' => \Porthd\Simpledataedit\Middleware\UpdateEditing::class,
            'after' => [
                'typo3/cms-frontend/backend-user-authentication',
                'typo3/cms-frontend/authentication'
            ],
            'before' => [
                'typo3/cms-adminpanel/initiator',
            ],
        ],
        'porthd/simpledataedit/resourcesforfrontendediting' => [
            'target' => \Porthd\Simpledataedit\Middleware\ResourcesForFrontendEditing::class,
            'after' => [
                'TYPO3\CMS\Frontend\Middleware\TypoScriptFrontendInitialization'
            ],
            'before' => [
                'typo3/cms-frontend/prepare-tsfe-renderin',
            ],
        ],
    ],
];