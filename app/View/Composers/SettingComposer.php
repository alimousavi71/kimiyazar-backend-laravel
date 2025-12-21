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
        // Only share settings for frontend views (not admin)
        // Check if view name or path contains 'admin'
        $viewName = $view->getName();
        $viewPath = $view->getPath();

        $isAdminView = str_starts_with($viewName, 'admin.')
            || str_contains($viewName, 'layouts.admin')
            || str_contains($viewName, 'components.layouts.admin')
            || (is_string($viewPath) && str_contains($viewPath, '/admin/'));

        if (!$isAdminView) {
            $view->with('settings', Setting::getAllAsArray());
        }
    }
}
