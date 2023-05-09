<?php

return [
    // Sets whether or not Messages should show up in sidebar navigation.
    'available-for-navigation' => true,

    // The resource to use as a messager. Typically the User resource.
    'messager' => [
        'nova-resource' => \App\Nova\User::class,
    ],

    // Configs for the messages panel
    'messages-panel' => [
        'name' => 'Messages',
    ],

    // Maximum length of message in messages panel
    'limit' => 100,
];
