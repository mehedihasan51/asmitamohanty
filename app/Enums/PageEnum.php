<?php

namespace App\Enums;

enum PageEnum: string
{
    const AUTH  = 'login';
    case HOME   = 'home';
    case ABOUT   = 'about';
    case COMMON = 'common';
    case SETTING = 'setting';
}
