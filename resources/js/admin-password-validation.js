import JustValidate from "just-validate";
import {
    fieldRequired,
    fieldMinLength,
    confirmPassword,
    passwordsDoNotMatch,
} from "./validation-messages.js";

/**
 * Admin Password Change Form Validation with Multi-language Support (Persian/English)
 */
document.addEventListener("DOMContentLoaded", function () {
    // Validation configuration
    const validationConfig = {
        errorFieldCssClass: "border-red-500",
        errorLabelCssClass: "text-red-600 text-xs mt-1",
        successFieldCssClass: "border-green-500",
    };

    // Password Change Form Validation
    const passwordForm =
        document.getElementById("admin-password-form") ||
        document.querySelector('form[action*="admin.admins.password.update"]');
    if (passwordForm) {
        const validation = new JustValidate(passwordForm, validationConfig);

        validation
            .addField("#password", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Password"),
                },
                {
                    rule: "minLength",
                    value: 8,
                    errorMessage: fieldMinLength("Password", 8),
                },
            ])
            .addField("#password_confirmation", [
                {
                    rule: "required",
                    errorMessage: confirmPassword(),
                },
                {
                    rule: "customRegexp",
                    value: () => {
                        const password =
                            document.getElementById("password")?.value || "";
                        const confirmPasswordValue =
                            document.getElementById("password_confirmation")
                                ?.value || "";
                        return password === confirmPasswordValue;
                    },
                    errorMessage: passwordsDoNotMatch(),
                },
            ])
            .onSuccess((event) => {
                // Allow form to submit normally after validation passes
                event.target.submit();
            });
    }
});
