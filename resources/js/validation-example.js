import JustValidate from "just-validate";

// Make JustValidate available globally
window.JustValidate = JustValidate;

/**
 * Initialize form validation examples
 */
document.addEventListener("DOMContentLoaded", function () {
    // Example 1: Basic Form Validation
    const basicForm = document.getElementById("basic-validation-form");
    if (basicForm) {
        const validation = new JustValidate("#basic-validation-form", {
            errorFieldCssClass: "border-red-500",
            errorLabelCssClass: "text-red-600 text-xs mt-1",
            successFieldCssClass: "border-green-500",
        });

        validation
            .addField("#basic-name", [
                {
                    rule: "required",
                    errorMessage: "Name is required",
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: "Name must be at least 3 characters",
                },
            ])
            .addField("#basic-email", [
                {
                    rule: "required",
                    errorMessage: "Email is required",
                },
                {
                    rule: "email",
                    errorMessage: "Email is invalid",
                },
            ])
            .addField("#basic-password", [
                {
                    rule: "required",
                    errorMessage: "Password is required",
                },
                {
                    rule: "minLength",
                    value: 8,
                    errorMessage: "Password must be at least 8 characters",
                },
            ])
            .onSuccess((event) => {
                if (window.Toast) {
                    window.Toast.success("Form validated successfully!");
                }
                // event.target.submit();
            });
    }

    // Example 2: Advanced Form Validation
    const advancedForm = document.getElementById("advanced-validation-form");
    if (advancedForm) {
        const validation = new JustValidate("#advanced-validation-form", {
            errorFieldCssClass: "border-red-500",
            errorLabelCssClass: "text-red-600 text-xs mt-1",
            successFieldCssClass: "border-green-500",
        });

        validation
            .addField("#advanced-username", [
                {
                    rule: "required",
                    errorMessage: "Username is required",
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: "Username must be at least 3 characters",
                },
                {
                    rule: "maxLength",
                    value: 20,
                    errorMessage: "Username must be less than 20 characters",
                },
                {
                    rule: "customRegexp",
                    value: /^[a-zA-Z0-9_]+$/,
                    errorMessage:
                        "Username can only contain letters, numbers, and underscores",
                },
            ])
            .addField("#advanced-email", [
                {
                    rule: "required",
                    errorMessage: "Email is required",
                },
                {
                    rule: "email",
                    errorMessage: "Email is invalid",
                },
            ])
            .addField("#advanced-phone", [
                {
                    rule: "required",
                    errorMessage: "Phone number is required",
                },
                {
                    rule: "customRegexp",
                    value: /^[\d\s\-\+\(\)]+$/,
                    errorMessage: "Phone number format is invalid",
                },
            ])
            .addField("#advanced-password", [
                {
                    rule: "required",
                    errorMessage: "Password is required",
                },
                {
                    rule: "minLength",
                    value: 8,
                    errorMessage: "Password must be at least 8 characters",
                },
                {
                    rule: "customRegexp",
                    value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/,
                    errorMessage:
                        "Password must contain uppercase, lowercase, and number",
                },
            ])
            .addField("#advanced-confirm-password", [
                {
                    rule: "required",
                    errorMessage: "Please confirm your password",
                },
                {
                    rule: "customRegexp",
                    value: () => {
                        const password =
                            document.getElementById("advanced-password")?.value;
                        const confirmPassword = document.getElementById(
                            "advanced-confirm-password"
                        )?.value;
                        return password === confirmPassword;
                    },
                    errorMessage: "Passwords do not match",
                },
            ])
            .addField("#advanced-age", [
                {
                    rule: "required",
                    errorMessage: "Age is required",
                },
                {
                    rule: "number",
                    errorMessage: "Age must be a number",
                },
                {
                    rule: "minNumber",
                    value: 18,
                    errorMessage: "You must be at least 18 years old",
                },
                {
                    rule: "maxNumber",
                    value: 120,
                    errorMessage: "Please enter a valid age",
                },
            ])
            .addField("#advanced-website", [
                {
                    rule: "customRegexp",
                    value: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,
                    errorMessage: "Please enter a valid URL",
                },
            ])
            .addField("#advanced-terms", [
                {
                    rule: "required",
                    errorMessage: "You must accept the terms and conditions",
                },
            ])
            .onSuccess((event) => {
                if (window.Toast) {
                    window.Toast.success("Form validated successfully!");
                }
                // event.target.submit();
            });
    }

    // Example 3: Real-time Validation
    const realtimeForm = document.getElementById("realtime-validation-form");
    if (realtimeForm) {
        const validation = new JustValidate("#realtime-validation-form", {
            errorFieldCssClass: "border-red-500",
            errorLabelCssClass: "text-red-600 text-xs mt-1",
            successFieldCssClass: "border-green-500",
        });

        validation
            .addField("#realtime-email", [
                {
                    rule: "required",
                    errorMessage: "Email is required",
                },
                {
                    rule: "email",
                    errorMessage: "Email is invalid",
                },
            ])
            .addField("#realtime-message", [
                {
                    rule: "required",
                    errorMessage: "Message is required",
                },
                {
                    rule: "minLength",
                    value: 10,
                    errorMessage: "Message must be at least 10 characters",
                },
                {
                    rule: "maxLength",
                    value: 500,
                    errorMessage: "Message must be less than 500 characters",
                },
            ])
            .onSuccess((event) => {
                if (window.Toast) {
                    window.Toast.success("Form validated successfully!");
                }
            });
    }
});
