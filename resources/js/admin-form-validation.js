import JustValidate from "just-validate";
import {
    fieldRequired,
    fieldMinLength,
    fieldMaxLength,
    fieldInvalid,
    confirmPassword,
    passwordsDoNotMatch,
} from "./validation-messages.js";

/**
 * Admin Form Validation with Multi-language Support (Persian/English)
 */
document.addEventListener("DOMContentLoaded", function () {
    // Validation configuration
    const validationConfig = {
        errorFieldCssClass: "border-red-500",
        errorLabelCssClass: "text-red-600 text-xs mt-1",
        successFieldCssClass: "border-green-500",
    };

    // Create Admin Form Validation
    const createForm =
        document.getElementById("admin-create-form") ||
        document.querySelector('form[action*="admin.admins.store"]');
    if (createForm) {
        const validation = new JustValidate(createForm, validationConfig);

        validation
            .addField("#first_name", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("First name"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: fieldMinLength("First name", 2),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: fieldMaxLength("First name", 255),
                },
            ])
            .addField("#last_name", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Last name"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: fieldMinLength("Last name", 2),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: fieldMaxLength("Last name", 255),
                },
            ])
            .addField("#email", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Email"),
                },
                {
                    rule: "email",
                    errorMessage: fieldInvalid("Email"),
                },
            ])
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
                            document.getElementById("password")?.value;
                        const confirmPasswordValue = document.getElementById(
                            "password_confirmation"
                        )?.value;
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

    // Edit Admin Form Validation
    const editForm =
        document.getElementById("admin-edit-form") ||
        document.querySelector('form[action*="admin.admins.update"]');
    if (editForm) {
        const validation = new JustValidate(editForm, validationConfig);

        validation
            .addField("#first_name", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("First name"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: fieldMinLength("First name", 2),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: fieldMaxLength("First name", 255),
                },
            ])
            .addField("#last_name", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Last name"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: fieldMinLength("Last name", 2),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: fieldMaxLength("Last name", 255),
                },
            ])
            .addField("#email", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Email"),
                },
                {
                    rule: "email",
                    errorMessage: fieldInvalid("Email"),
                },
            ])
            .onSuccess((event) => {
                event.target.submit();
            });
    }

    // Profile Edit Form Validation
    const profileEditForm =
        document.getElementById("profile-edit-form") ||
        document.querySelector('form[action*="admin.profile.update"]');
    if (profileEditForm) {
        const validation = new JustValidate(profileEditForm, validationConfig);

        validation
            .addField("#first_name", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("First name"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: fieldMinLength("First name", 2),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: fieldMaxLength("First name", 255),
                },
            ])
            .addField("#last_name", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Last name"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: fieldMinLength("Last name", 2),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: fieldMaxLength("Last name", 255),
                },
            ])
            .addField("#email", [
                {
                    rule: "required",
                    errorMessage: fieldRequired("Email"),
                },
                {
                    rule: "email",
                    errorMessage: fieldInvalid("Email"),
                },
            ])
            .onSuccess((event) => {
                event.target.submit();
            });
    }
});
