import JustValidate from "just-validate";

/**
 * Admin Form Validation with Multi-language Support (Persian/English)
 */
document.addEventListener("DOMContentLoaded", function () {
    // Detect current locale
    const currentLocale = document.documentElement.lang?.split("-")[0] || "en";
    const isPersian = currentLocale === "fa" || currentLocale === "ar";

    // Persian validation messages
    const persianMessages = {
        "First name is required": "نام الزامی است",
        "First name must be at least 2 characters":
            "نام باید حداقل 2 کاراکتر باشد",
        "First name must be less than 255 characters":
            "نام باید کمتر از 255 کاراکتر باشد",
        "Last name is required": "نام خانوادگی الزامی است",
        "Last name must be at least 2 characters":
            "نام خانوادگی باید حداقل 2 کاراکتر باشد",
        "Last name must be less than 255 characters":
            "نام خانوادگی باید کمتر از 255 کاراکتر باشد",
        "Email is required": "ایمیل الزامی است",
        "Email is invalid": "ایمیل نامعتبر است",
        "This email is already taken": "این ایمیل قبلاً استفاده شده است",
        "Password is required": "رمز عبور الزامی است",
        "Password must be at least 8 characters":
            "رمز عبور باید حداقل 8 کاراکتر باشد",
        "Please confirm your password": "لطفاً رمز عبور را تأیید کنید",
        "Passwords do not match": "رمزهای عبور مطابقت ندارند",
    };

    // English validation messages
    const englishMessages = {
        "First name is required": "First name is required",
        "First name must be at least 2 characters":
            "First name must be at least 2 characters",
        "First name must be less than 255 characters":
            "First name must be less than 255 characters",
        "Last name is required": "Last name is required",
        "Last name must be at least 2 characters":
            "Last name must be at least 2 characters",
        "Last name must be less than 255 characters":
            "Last name must be less than 255 characters",
        "Email is required": "Email is required",
        "Email is invalid": "Email is invalid",
        "This email is already taken": "This email is already taken",
        "Password is required": "Password is required",
        "Password must be at least 8 characters":
            "Password must be at least 8 characters",
        "Please confirm your password": "Please confirm your password",
        "Passwords do not match": "Passwords do not match",
    };

    // Select messages based on locale
    const messages = isPersian ? persianMessages : englishMessages;

    // Helper function to get translated message
    const getMessage = (key) => messages[key] || key;

    // Validation configuration
    const validationConfig = {
        errorFieldCssClass: "border-red-500",
        errorLabelCssClass: "text-red-600 text-xs mt-1",
        successFieldCssClass: "border-green-500",
    };

    // Create Admin Form Validation
    const createForm =
        document.getElementById("admin-create-form") ||
        document.querySelector('form[action*="admin.admins.store"]') ||
        document.querySelector('form[action*="/admin/admins"]');
    if (createForm) {
        const validation = new JustValidate(createForm, validationConfig);

        validation
            .addField("#first_name", [
                {
                    rule: "required",
                    errorMessage: getMessage("First name is required"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: getMessage(
                        "First name must be at least 2 characters"
                    ),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: getMessage(
                        "First name must be less than 255 characters"
                    ),
                },
            ])
            .addField("#last_name", [
                {
                    rule: "required",
                    errorMessage: getMessage("Last name is required"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: getMessage(
                        "Last name must be at least 2 characters"
                    ),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: getMessage(
                        "Last name must be less than 255 characters"
                    ),
                },
            ])
            .addField("#email", [
                {
                    rule: "required",
                    errorMessage: getMessage("Email is required"),
                },
                {
                    rule: "email",
                    errorMessage: getMessage("Email is invalid"),
                },
            ])
            .addField("#password", [
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
            .addField("#password_confirmation", [
                {
                    rule: "required",
                    errorMessage: getMessage("Please confirm your password"),
                },
                {
                    rule: "customRegexp",
                    value: () => {
                        const password =
                            document.getElementById("password")?.value;
                        const confirmPassword = document.getElementById(
                            "password_confirmation"
                        )?.value;
                        return password === confirmPassword;
                    },
                    errorMessage: getMessage("Passwords do not match"),
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
        document.querySelector('form[action*="admin.admins.update"]') ||
        document.querySelector('form[method="PUT"]');
    if (editForm) {
        const validation = new JustValidate(editForm, validationConfig);

        validation
            .addField("#first_name", [
                {
                    rule: "required",
                    errorMessage: getMessage("First name is required"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: getMessage(
                        "First name must be at least 2 characters"
                    ),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: getMessage(
                        "First name must be less than 255 characters"
                    ),
                },
            ])
            .addField("#last_name", [
                {
                    rule: "required",
                    errorMessage: getMessage("Last name is required"),
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: getMessage(
                        "Last name must be at least 2 characters"
                    ),
                },
                {
                    rule: "maxLength",
                    value: 255,
                    errorMessage: getMessage(
                        "Last name must be less than 255 characters"
                    ),
                },
            ])
            .addField("#email", [
                {
                    rule: "required",
                    errorMessage: getMessage("Email is required"),
                },
                {
                    rule: "email",
                    errorMessage: getMessage("Email is invalid"),
                },
            ])
            .addField("#password", [
                {
                    rule: "minLength",
                    value: 8,
                    errorMessage: getMessage(
                        "Password must be at least 8 characters"
                    ),
                },
            ])
            .addField("#password_confirmation", [
                {
                    rule: "customRegexp",
                    value: () => {
                        const password =
                            document.getElementById("password")?.value || "";
                        const confirmPassword =
                            document.getElementById("password_confirmation")
                                ?.value || "";

                        // If password is empty, confirmation can be empty too (password is optional on edit)
                        if (!password && !confirmPassword) {
                            return true;
                        }

                        // If password is provided, confirmation is required and must match
                        if (password) {
                            if (!confirmPassword) {
                                return false;
                            }
                            return password === confirmPassword;
                        }

                        // If confirmation is provided but password is not, it's invalid
                        if (confirmPassword && !password) {
                            return false;
                        }

                        return true;
                    },
                    errorMessage: getMessage("Passwords do not match"),
                },
            ])
            .onSuccess((event) => {
                // Allow form to submit normally after validation passes
                event.target.submit();
            });
    }
});
