<?php
/**
* @copyright Copyright (c) ARONET GmbH (https://aronet.swiss)
* @license AGPL-3.0
*
* This code is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License, version 3,
* along with this program.  If not, see <http://www.gnu.org/licenses/>
*
*/

return new \Phalcon\Config([
    'permissionbase' => [
        'index' => [
            'general' => [
                'description' => 'General access', 
                'scopes' => [
                    '1' => "Show all",
                    '0' => "Show nothing",
                ],
                'actions' => [
                    'index' => [
                        'index', 'toggleSidebar',
                    ],
                    'logins' => [
                        'editProfile', 'formProfile', 'updateProfile', 'profile', 'saveBootswatchTheme', 'resetPasswordForm', 'resetPassword',
                    ]
                ],
            ],
        ],
        'administration' => [
            'general' => [
                'description' => 'Administration access', 
                'scopes' => [
                    '1' => "Show all",
                    '0' => "Show nothing",
                ],
                'actions' => [
                    'administration' => [
                        'index', 'genPermissionsPDF', 'genOVZJobsPDF', 'genActionsPDF', 'deployRootKeys',
                        'faker', 'fakeCustomers', 'fakeLogins', 'fakePartners',
                    ]
                ],
            ],
        ],
    ]
]);
