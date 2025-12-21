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
    const contactForm = document.querySelector(".contact-form");
    if (!contactForm) {
        return;
    }

    const validation = new JustValidate(contactForm, {
        errorFieldCssClass: "border-red-500",
        errorLabelCssClass: "text-red-600 text-xs mt-1",
        successFieldCssClass: "border-green-500",
    });

    // Title field (required)
    validation.addField("#title", [
        {
            rule: "required",
            errorMessage: fieldRequired("عنوان"),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: fieldMaxLength("عنوان", 255),
        },
    ]);

    // Mobile field (required)
    validation.addField("#mobile", [
        {
            rule: "required",
            errorMessage: fieldRequired("شماره موبایل"),
        },
        {
            rule: "customRegexp",
            value: (value) => {
                // Must match Iranian mobile format
                return /^09\d{9}$/.test(value);
            },
            errorMessage: "شماره موبایل باید با 09 شروع شود و 11 رقم باشد",
        },
        {
            rule: "maxLength",
            value: 11,
            errorMessage: fieldMaxLength("شماره موبایل", 11),
        },
    ]);

    // Email field (required)
    validation.addField("#email", [
        {
            rule: "required",
            errorMessage: fieldRequired("ایمیل"),
        },
        {
            rule: "email",
            errorMessage: fieldInvalid("ایمیل"),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: fieldMaxLength("ایمیل", 255),
        },
    ]);

    // Text field (required)
    validation.addField("#text", [
        {
            rule: "required",
            errorMessage: fieldRequired("متن پیام"),
        },
        {
            rule: "minLength",
            value: 10,
            errorMessage: fieldMinLength("متن پیام", 10),
        },
        {
            rule: "maxLength",
            value: 2000,
            errorMessage: fieldMaxLength("متن پیام", 2000),
        },
    ]);

    // On form success, submit the form
    validation.onSuccess((event) => {
        // Form will submit normally
        return true;
    });
});
