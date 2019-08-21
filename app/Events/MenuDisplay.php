<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Menu;

class MenuDisplay
{
    use SerializesModels;

    public $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;

        // @deprecate
        //
        event('menu.display', $menu);
    }
}
