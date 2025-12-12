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

    // Example 4: Multi-language Validation (Persian/English)
    const multilangForm = document.getElementById("multilang-validation-form");
    if (multilangForm) {
        // Detect current locale from HTML lang attribute or app locale
        const currentLocale =
            document.documentElement.lang?.split("-")[0] || "en";
        const isPersian = currentLocale === "fa" || currentLocale === "ar";

        // Update locale display
        const localeDisplay = document.getElementById("current-locale-display");
        if (localeDisplay) {
            localeDisplay.textContent = currentLocale.toUpperCase();
        }

        // Persian validation messages
        const persianMessages = {
            "Field is required": "پر کردن این فیلد الزامی است",
            "First name is required": "نام الزامی است",
            "Last name is required": "نام خانوادگی الزامی است",
            "Email is required": "ایمیل الزامی است",
            "Email is invalid": "ایمیل نامعتبر است",
            "Password is required": "رمز عبور الزامی است",
            "Password must be at least 8 characters":
                "رمز عبور باید حداقل 8 کاراکتر باشد",
            "Please confirm your password": "لطفاً رمز عبور را تأیید کنید",
            "Passwords do not match": "رمزهای عبور مطابقت ندارند",
            "Phone number is required": "شماره تلفن الزامی است",
            "Phone number format is invalid": "فرمت شماره تلفن نامعتبر است",
            "Bio must be less than 200 characters":
                "بیوگرافی باید کمتر از 200 کاراکتر باشد",
            "You must accept the terms and conditions":
                "شما باید شرایط و قوانین را بپذیرید",
            "Name must be at least 3 characters":
                "نام باید حداقل 3 کاراکتر باشد",
            "Name must be less than 50 characters":
                "نام باید کمتر از 50 کاراکتر باشد",
        };

        // English validation messages (default)
        const englishMessages = {
            "Field is required": "Field is required",
            "First name is required": "First name is required",
            "Last name is required": "Last name is required",
            "Email is required": "Email is required",
            "Email is invalid": "Email is invalid",
            "Password is required": "Password is required",
            "Password must be at least 8 characters":
                "Password must be at least 8 characters",
            "Please confirm your password": "Please confirm your password",
            "Passwords do not match": "Passwords do not match",
            "Phone number is required": "Phone number is required",
            "Phone number format is invalid": "Phone number format is invalid",
            "Bio must be less than 200 characters":
                "Bio must be less than 200 characters",
            "You must accept the terms and conditions":
                "You must accept the terms and conditions",
            "Name must be at least 3 characters":
                "Name must be at least 3 characters",
            "Name must be less than 50 characters":
                "Name must be less than 50 characters",
        };

        // Select messages based on locale
        const messages = isPersian ? persianMessages : englishMessages;

        // Helper function to get translated message
        const getMessage = (key) => messages[key] || key;

        const validation = new JustValidate("#multilang-validation-form", {
            errorFieldCssClass: "border-red-500",
            errorLabelCssClass: "text-red-600 text-xs mt-1",
            successFieldCssClass: "border-green-500",
        });

        validation
            .addField("#multilang-first-name", [
                {
                    rule: "required",
                    errorMessage: getMessage("First name is required"),
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: getMessage(
                        "Name must be at least 3 characters"
                    ),
                },
                {
                    rule: "maxLength",
                    value: 50,
                    errorMessage: getMessage(
                        "Name must be less than 50 characters"
                    ),
                },
            ])
            .addField("#multilang-last-name", [
                {
                    rule: "required",
                    errorMessage: getMessage("Last name is required"),
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: getMessage(
                        "Name must be at least 3 characters"
                    ),
                },
                {
                    rule: "maxLength",
                    value: 50,
                    errorMessage: getMessage(
                        "Name must be less than 50 characters"
                    ),
                },
            ])
            .addField("#multilang-email", [
                {
                    rule: "required",
                    errorMessage: getMessage("Email is required"),
                },
                {
                    rule: "email",
                    errorMessage: getMessage("Email is invalid"),
                },
            ])
            .addField("#multilang-password", [
                {
                    rule: "required",
                    errorMessage: getMessage("Password is required"),
                },
                {
                    rule: "minLength",
                    value: 8,
                    errorMessage: getMessage(
                        "Password must be at least 8 characters"
                    ),
                },
            ])
            .addField("#multilang-confirm-password", [
                {
                    rule: "required",
                    errorMessage: getMessage("Please confirm your password"),
                },
                {
                    rule: "customRegexp",
                    value: () => {
                        const password =
                            document.getElementById(
                                "multilang-password"
                            )?.value;
                        const confirmPassword = document.getElementById(
                            "multilang-confirm-password"
                        )?.value;
                        return password === confirmPassword;
                    },
                    errorMessage: getMessage("Passwords do not match"),
                },
            ])
            .addField("#multilang-phone", [
                {
                    rule: "required",
                    errorMessage: getMessage("Phone number is required"),
                },
                {
                    rule: "customRegexp",
                    value: /^[\d\s\-\+\(\)]+$/,
                    errorMessage: getMessage("Phone number format is invalid"),
                },
            ])
            .addField("#multilang-bio", [
                {
                    rule: "maxLength",
                    value: 200,
                    errorMessage: getMessage(
                        "Bio must be less than 200 characters"
                    ),
                },
            ])
            .addField("#multilang-terms", [
                {
                    rule: "required",
                    errorMessage: getMessage(
                        "You must accept the terms and conditions"
                    ),
                },
            ])
            .onSuccess((event) => {
                if (window.Toast) {
                    const successMsg = isPersian
                        ? "فرم با موفقیت اعتبارسنجی شد!"
                        : "Form validated successfully!";
                    window.Toast.success(successMsg);
                }
            });
    }
});
