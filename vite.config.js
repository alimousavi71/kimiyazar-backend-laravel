import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/slider.js",
                "resources/js/product-chart.js",
                "resources/js/imask-test.js",
                "resources/js/validation-example.js",
                "resources/js/admin-form-validation.js",
                "resources/js/admin-password-validation.js",
                "resources/js/contact-form-validation.js",
                "resources/js/price-inquiry-validation.js",
                "resources/js/category-selector.js",
                "resources/js/dropdown-menu.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
