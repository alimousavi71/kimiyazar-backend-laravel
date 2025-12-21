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
                "resources/js/imask-test.js",
                "resources/js/validation-example.js",
                "resources/js/admin-form-validation.js",
                "resources/js/admin-password-validation.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
