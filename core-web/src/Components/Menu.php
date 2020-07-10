<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $menuItem;
    
    public function __construct()
    {
        if (Auth::check())
            $this->menuItem = Session::get('menu_user');
    }
    
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if (Auth::check())
            return view('components.menu');
            else
                return null;
    }
}
