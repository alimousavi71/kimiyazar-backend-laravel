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
        // Only share menus for frontend views (not admin)
        $viewName = $view->getName();
        $viewPath = $view->getPath();

        $isAdminView = str_starts_with($viewName, 'admin.')
            || str_contains($viewName, 'layouts.admin')
            || str_contains($viewName, 'components.layouts.admin')
            || (is_string($viewPath) && str_contains($viewPath, '/admin/'));

        if (!$isAdminView) {
            $view->with([
                'quickAccessMenu' => Menu::findByType('quick_access'),
                'servicesMenu' => Menu::findByType('services'),
            ]);
        }
    }
}
