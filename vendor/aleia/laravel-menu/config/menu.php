<?php

return [
    'models' => [

        'menu' => aleia\LaravelMenu\Models\Menu::class,

        'menu_item' => aleia\LaravelMenu\Models\MenuItem::class,
    ],

    'table_names' => [

        'menus' => 'menus',

        'menu_items' => 'menu_items',
    ]
];
