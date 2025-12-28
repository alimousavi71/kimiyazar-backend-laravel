<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Bind menu data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        // Share menus only for frontend views
        // Composer is only registered for frontend views, so no need to check
        $view->with([
            'quickAccessMenu' => Menu::findByType('quick_access'),
            'servicesMenu' => Menu::findByType('services'),
        ]);
    }
}
