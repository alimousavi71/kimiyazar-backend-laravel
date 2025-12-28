<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingComposer
{
    /**
     * Bind settings data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        // Share settings only for frontend views
        // Composer is only registered for frontend views, so no need to check
        $view->with('settings', Setting::getAllAsArray());
    }
}
