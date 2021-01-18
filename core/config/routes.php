<?php
return [
    '/' => static function () {
        echo 'hello world';
    },
    '/class/' => 'Main@index',
    '/calendar/' => 'Calendar@index',
    '/calendar/{i}/{i}/'=>'Calendar@render',
    '/calendar/{i}/'=>'Calendar@year',
    '/calendar/{i}/{i}/{i}/'=>'Calendar@show',
    '/calendar/{i}/delete/' => 'Calendar@delete',
    '/login/'=>'User@index',
    '/logout/' => 'User@logout',
    '/calendar/add/{d}/' => 'Calendar@add',
    '/register/' => 'User@register',
];