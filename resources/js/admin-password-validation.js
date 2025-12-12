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

    // Admin Password Change Form Validation
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
                event.target.submit();
            });
    }

    // Profile Password Change Form Validation
    const profilePasswordForm =
        document.getElementById("profile-password-form") ||
        document.querySelector('form[action*="admin.profile.password.update"]');
    if (profilePasswordForm) {
        const validation = new JustValidate(
            profilePasswordForm,
            validationConfig
        );

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
                event.target.submit();
            });
    }
});
