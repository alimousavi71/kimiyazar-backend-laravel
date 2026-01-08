import JustValidate from "just-validate";
import {
    fieldRequired,
    fieldMinLength,
    fieldMaxLength,
    fieldInvalid,
} from "./validation-messages.js";

/**
 * Contact Form Validation
 */
document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.getElementById("contact-form");
    if (!contactForm) {
        return;
    }

    // Detect locale
    const locale = document.documentElement.lang?.split("-")[0] || "en";
    const isPersian = locale === "fa" || locale === "ar";

    const validation = new JustValidate(contactForm, {
        errorFieldCssClass: "border-red-500",
        errorLabelCssClass: "text-red-600 text-xs mt-1",
        successFieldCssClass: "border-green-500",
        validateBeforeSubmitting: true,
    });

    // Title field (required)
    validation.addField("#title", [
        {
            rule: "required",
            errorMessage: isPersian
                ? fieldRequired("عنوان", locale)
                : fieldRequired("Title", locale),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: isPersian
                ? fieldMaxLength("عنوان", 255, locale)
                : fieldMaxLength("Title", 255, locale),
        },
    ]);

    // Mobile field (required)
    validation.addField("#mobile", [
        {
            rule: "required",
            errorMessage: isPersian
                ? fieldRequired("شماره موبایل", locale)
                : fieldRequired("Mobile", locale),
        },
        {
            rule: "customRegexp",
            value: (value) => {
                // Accept Iranian mobile format with or without leading zero
                // 09123456789 (11 digits) or 9123456789 (10 digits)
                return /^(09\d{9}|9\d{9})$/.test(value);
            },
            errorMessage: isPersian
                ? "شماره موبایل باید معتبر باشد. (مثال: 09123456789 یا 9123456789)"
                : "Mobile number must be valid. (Example: 09123456789 or 9123456789)",
        },
        {
            rule: "maxLength",
            value: 11,
            errorMessage: isPersian
                ? "شماره موبایل نباید بیشتر از 11 رقم باشد"
                : "Mobile number must not exceed 11 digits",
        },
    ]);

    // Email field (optional)
    validation.addField("#email", [
        {
            rule: "email",
            errorMessage: isPersian
                ? fieldInvalid("ایمیل", locale)
                : fieldInvalid("Email", locale),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: isPersian
                ? fieldMaxLength("ایمیل", 255, locale)
                : fieldMaxLength("Email", 255, locale),
        },
    ]);

    // Text field (required)
    validation.addField("#text", [
        {
            rule: "required",
            errorMessage: isPersian
                ? fieldRequired("متن پیام", locale)
                : fieldRequired("Message", locale),
        },
        {
            rule: "minLength",
            value: 10,
            errorMessage: isPersian
                ? fieldMinLength("متن پیام", 10, locale)
                : fieldMinLength("Message", 10, locale),
        },
        {
            rule: "maxLength",
            value: 2000,
            errorMessage: isPersian
                ? fieldMaxLength("متن پیام", 2000, locale)
                : fieldMaxLength("Message", 2000, locale),
        },
    ]);

    // CAPTCHA field (required)
    validation.addField("#captcha", [
        {
            rule: "required",
            errorMessage: isPersian
                ? "کد امنیتی الزامی است"
                : "Security code is required",
        },
        {
            rule: "minLength",
            value: 4,
            errorMessage: isPersian
                ? "کد امنیتی باید حداقل 4 کاراکتر باشد"
                : "Security code must be at least 4 characters",
        },
        {
            rule: "maxLength",
            value: 6,
            errorMessage: isPersian
                ? "کد امنیتی نباید بیشتر از 6 کاراکتر باشد"
                : "Security code must not exceed 6 characters",
        },
    ]);

    // Enable live validation on blur
    const fields = ["#title", "#mobile", "#email", "#text", "#captcha"];
    fields.forEach((fieldSelector) => {
        const field = contactForm.querySelector(fieldSelector);
        if (field) {
            field.addEventListener("blur", () => {
                validation.revalidateField(fieldSelector);
            });
        }
    });

    // On form success, submit the form
    validation.onSuccess((event) => {
        event.target.submit();
    });
});
