<?php

return [
    'layout' => env('CW_LAYOUT', 'layouts.app'),
    'views' => env('CW_VIEWS', 'task::tasks.'),
    'priorities' => [
        5 => 'Muito alta',
        4 =>'Alta',
        3 => 'Normal',
        2 => 'Baixa',
        1=> 'Muito baixa'
    ]
];
