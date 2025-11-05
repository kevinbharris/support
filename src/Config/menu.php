<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Support Menu Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the admin menu structure for the Support module.
    | The menu is registered in the admin sidebar.
    |
    */
		[ 
			'key'    => 'support',
			'name'  => 'Help Desk',
			'route'  => 'admin.support.tickets.index',
			'sort'   => 4,
			'icon'   => 'icon-ticket',
		],[
            'key'   => 'support.canned_responses',
            'name' => 'Canned Responses',
            'route' => 'admin.support.canned-responses.index',
            'icon'  => 'icon-canned-responses',
            'sort'  => 1,
        ],[
            'key'   => 'support.categories',
            'name' => 'Categories',
            'route' => 'admin.support.categories.index',
            'icon'  => 'icon-categories',
            'sort'  => 2,
        ],[
            'key'   => 'support.priorities',
            'name' => 'Priorities',
            'route' => 'admin.support.priorities.index',
            'icon'  => 'icon-priorities',
            'sort'  => 3,
        ],[
            'key'   => 'support.rules',
            'name' => 'Rules',
            'route' => 'admin.support.rules.index',
            'icon'  => 'icon-rules',
            'sort'  => 4,
        ],[
            'key'   => 'support.statuses',
            'name' => 'Statuses',
            'route' => 'admin.support.statuses.index',
            'icon'  => 'icon-statuses',
            'sort'  => 5,
        ],[
            'key'   => 'support.tickets',
            'name' => 'Tickets',
            'route' => 'admin.support.tickets.index',
            'icon'  => 'icon-ticket',
            'sort'  => 6,
        ],
];
