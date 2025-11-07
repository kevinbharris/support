<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Support Module Permissions
    |--------------------------------------------------------------------------
    |
    | This file defines all permissions for the Support module.
    | These permissions are registered as gates and can be assigned to roles
    | in the Bagisto admin panel.
    |
    | This config returns a flat array of permissions (not nested under a key).
    |
    */

    // Ticket Permissions
    [
        'key' => 'support.tickets',
        'name' => 'support::acl.tickets.title',
        'route' => 'admin.support.tickets.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.tickets.view',
        'name' => 'support::acl.tickets.view',
        'route' => 'admin.support.tickets.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.tickets.create',
        'name' => 'support::acl.tickets.create',
        'route' => 'admin.support.tickets.create',
        'sort' => 2,
    ],
    [
        'key' => 'support.tickets.update',
        'name' => 'support::acl.tickets.update',
        'route' => 'admin.support.tickets.edit',
        'sort' => 3,
    ],
    [
        'key' => 'support.tickets.delete',
        'name' => 'support::acl.tickets.delete',
        'route' => null,
        'sort' => 4,
    ],
    [
        'key' => 'support.tickets.assign',
        'name' => 'support::acl.tickets.assign',
        'route' => null,
        'sort' => 5,
    ],
    [
        'key' => 'support.tickets.notes',
        'name' => 'support::acl.tickets.notes',
        'route' => null,
        'sort' => 6,
    ],
    [
        'key' => 'support.tickets.watchers',
        'name' => 'support::acl.tickets.watchers',
        'route' => null,
        'sort' => 7,
    ],

    // Status Permissions
    [
        'key' => 'support.statuses',
        'name' => 'support::acl.statuses.title',
        'route' => 'admin.support.statuses.index',
        'sort' => 2,
    ],
    [
        'key' => 'support.statuses.view',
        'name' => 'support::acl.statuses.view',
        'route' => 'admin.support.statuses.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.statuses.create',
        'name' => 'support::acl.statuses.create',
        'route' => 'admin.support.statuses.create',
        'sort' => 2,
    ],
    [
        'key' => 'support.statuses.update',
        'name' => 'support::acl.statuses.update',
        'route' => 'admin.support.statuses.edit',
        'sort' => 3,
    ],
    [
        'key' => 'support.statuses.delete',
        'name' => 'support::acl.statuses.delete',
        'route' => null,
        'sort' => 4,
    ],

    // Priority Permissions
    [
        'key' => 'support.priorities',
        'name' => 'support::acl.priorities.title',
        'route' => 'admin.support.priorities.index',
        'sort' => 3,
    ],
    [
        'key' => 'support.priorities.view',
        'name' => 'support::acl.priorities.view',
        'route' => 'admin.support.priorities.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.priorities.create',
        'name' => 'support::acl.priorities.create',
        'route' => 'admin.support.priorities.create',
        'sort' => 2,
    ],
    [
        'key' => 'support.priorities.update',
        'name' => 'support::acl.priorities.update',
        'route' => 'admin.support.priorities.edit',
        'sort' => 3,
    ],
    [
        'key' => 'support.priorities.delete',
        'name' => 'support::acl.priorities.delete',
        'route' => null,
        'sort' => 4,
    ],

    // Category Permissions
    [
        'key' => 'support.categories',
        'name' => 'support::acl.categories.title',
        'route' => 'admin.support.categories.index',
        'sort' => 4,
    ],
    [
        'key' => 'support.categories.view',
        'name' => 'support::acl.categories.view',
        'route' => 'admin.support.categories.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.categories.create',
        'name' => 'support::acl.categories.create',
        'route' => 'admin.support.categories.create',
        'sort' => 2,
    ],
    [
        'key' => 'support.categories.update',
        'name' => 'support::acl.categories.update',
        'route' => 'admin.support.categories.edit',
        'sort' => 3,
    ],
    [
        'key' => 'support.categories.delete',
        'name' => 'support::acl.categories.delete',
        'route' => null,
        'sort' => 4,
    ],

    // Canned Response Permissions
    [
        'key' => 'support.canned-responses',
        'name' => 'support::acl.canned-responses.title',
        'route' => 'admin.support.canned-responses.index',
        'sort' => 5,
    ],
    [
        'key' => 'support.canned-responses.view',
        'name' => 'support::acl.canned-responses.view',
        'route' => 'admin.support.canned-responses.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.canned-responses.create',
        'name' => 'support::acl.canned-responses.create',
        'route' => 'admin.support.canned-responses.create',
        'sort' => 2,
    ],
    [
        'key' => 'support.canned-responses.update',
        'name' => 'support::acl.canned-responses.update',
        'route' => 'admin.support.canned-responses.edit',
        'sort' => 3,
    ],
    [
        'key' => 'support.canned-responses.delete',
        'name' => 'support::acl.canned-responses.delete',
        'route' => null,
        'sort' => 4,
    ],

    // Rule Permissions
    [
        'key' => 'support.rules',
        'name' => 'support::acl.rules.title',
        'route' => 'admin.support.rules.index',
        'sort' => 6,
    ],
    [
        'key' => 'support.rules.view',
        'name' => 'support::acl.rules.view',
        'route' => 'admin.support.rules.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.rules.create',
        'name' => 'support::acl.rules.create',
        'route' => 'admin.support.rules.create',
        'sort' => 2,
    ],
    [
        'key' => 'support.rules.update',
        'name' => 'support::acl.rules.update',
        'route' => 'admin.support.rules.edit',
        'sort' => 3,
    ],
    [
        'key' => 'support.rules.delete',
        'name' => 'support::acl.rules.delete',
        'route' => null,
        'sort' => 4,
    ],

    // Note Permissions
    [
        'key' => 'support.notes',
        'name' => 'support::acl.notes.title',
        'route' => null,
        'sort' => 7,
    ],
    [
        'key' => 'support.notes.view',
        'name' => 'support::acl.notes.view',
        'route' => null,
        'sort' => 1,
    ],
    [
        'key' => 'support.notes.create',
        'name' => 'support::acl.notes.create',
        'route' => null,
        'sort' => 2,
    ],
    [
        'key' => 'support.notes.delete',
        'name' => 'support::acl.notes.delete',
        'route' => null,
        'sort' => 3,
    ],

    // Attachment Permissions
    [
        'key' => 'support.attachments',
        'name' => 'support::acl.attachments.title',
        'route' => null,
        'sort' => 8,
    ],
    [
        'key' => 'support.attachments.view',
        'name' => 'support::acl.attachments.view',
        'route' => null,
        'sort' => 1,
    ],
    [
        'key' => 'support.attachments.create',
        'name' => 'support::acl.attachments.create',
        'route' => null,
        'sort' => 2,
    ],
    [
        'key' => 'support.attachments.delete',
        'name' => 'support::acl.attachments.delete',
        'route' => null,
        'sort' => 3,
    ],
];
