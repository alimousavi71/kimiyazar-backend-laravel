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
                // Must match Iranian mobile format
                return /^09\d{9}$/.test(value);
            },
            errorMessage: isPersian
                ? "شماره موبایل باید با 09 شروع شود و 11 رقم باشد"
                : "Mobile number must start with 09 and be 11 digits",
        },
        {
            rule: "maxLength",
            value: 11,
            errorMessage: isPersian
                ? fieldMaxLength("شماره موبایل", 11, locale)
                : fieldMaxLength("Mobile", 11, locale),
        },
    ]);

    // Email field (required)
    validation.addField("#email", [
        {
            rule: "required",
            errorMessage: isPersian
                ? fieldRequired("ایمیل", locale)
                : fieldRequired("Email", locale),
        },
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

    // Enable live validation on blur
    const fields = ["#title", "#mobile", "#email", "#text"];
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
