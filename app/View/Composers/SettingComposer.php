<?php

namespace App\View\Composers;

use App\Models\Setting;
use App\Models\Tag;
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
        $view->with([
            'settings' => Setting::getAllAsArray(),
            // Fetch tags that have taggables (are actually used), randomize and limit 10
            'tags' => Tag::whereHas('tagables')
                ->inRandomOrder()
                ->limit(10)
                ->get(),
        ]);
    }
}
