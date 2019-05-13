<?php

return array(
    'dayside' => 'site/dayside',
    // main:
    'page-([0-9]+)' => 'site/index/$1',
    'filter/clear' => 'site/clearFilter',
    'filter/filtered' => 'site/filter',

    // Пользователь:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',

    // Задать задание:
    'goal' => 'goal/index',

    // 404
    '((.|\n)+)' => 'site/404',
    // Главная страница
    '' => 'site/index', // actionIndex в SiteController
);
