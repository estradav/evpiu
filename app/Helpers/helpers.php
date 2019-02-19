<?php

if (!function_exists('evpiu_menu')) {
    function evpiu_menu($menuName, $type = null, array $options = [])
    {
        return App\Menu::display($menuName, $type, $options);
    }
}
