import JustValidate from "just-validate";
import {
    fieldRequired,
    fieldMinLength,
    fieldMaxLength,
    fieldInvalid,
} from "./validation-messages.js";

/**
 * Price Inquiry Form Validation
 */
document.addEventListener("DOMContentLoaded", function () {
    const priceInquiryForm = document.getElementById("price-inquiry-form");
    if (!priceInquiryForm) {
        return;
    }

    // Detect locale
    const locale = document.documentElement.lang?.split("-")[0] || "en";
    const isPersian = locale === "fa" || locale === "ar";

    const validation = new JustValidate(priceInquiryForm, {
        errorFieldCssClass: "border-red-500",
        errorLabelCssClass: "text-red-600 text-xs mt-1",
        successFieldCssClass: "border-green-500",
        validateBeforeSubmitting: true,
    });

    // First Name validation
    validation.addField("#first_name", [
        {
            rule: "required",
            errorMessage: fieldRequired("First name", locale),
        },
        {
            rule: "minLength",
            value: 2,
            errorMessage: fieldMinLength("First name", 2, locale),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: fieldMaxLength("First name", 255, locale),
        },
    ]);

    // Last Name validation
    validation.addField("#last_name", [
        {
            rule: "required",
            errorMessage: fieldRequired("Last name", locale),
        },
        {
            rule: "minLength",
            value: 2,
            errorMessage: fieldMinLength("Last name", 2, locale),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: fieldMaxLength("Last name", 255, locale),
        },
    ]);

    // Email validation
    validation.addField("#email", [
        {
            rule: "required",
            errorMessage: fieldRequired("Email", locale),
        },
        {
            rule: "email",
            errorMessage: fieldInvalid("Email", locale),
        },
        {
            rule: "maxLength",
            value: 255,
            errorMessage: fieldMaxLength("Email", 255, locale),
        },
    ]);

    // Phone Number validation
    validation.addField("#phone_number", [
        {
            rule: "required",
            errorMessage: fieldRequired("Phone number", locale),
        },
        {
            rule: "maxLength",
            value: 20,
            errorMessage: fieldMaxLength("Phone number", 20, locale),
        },
    ]);

    // CAPTCHA validation
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
    const fields = ["#first_name", "#last_name", "#email", "#phone_number", "#captcha"];
    fields.forEach((fieldSelector) => {
        const field = priceInquiryForm.querySelector(fieldSelector);
        if (field) {
            field.addEventListener("blur", () => {
                validation.revalidateField(fieldSelector);
            });
        }
    });

    // Validate products on form submission
    validation.onSuccess((event) => {
        const productInputs = Array.from(
            priceInquiryForm.querySelectorAll('input[name="products[]"]')
        );
        const productIds = productInputs
            .map((input) => input.value)
            .filter((value) => value && value.trim() !== "");

        // Remove any existing error messages
        const errorContainer = priceInquiryForm.querySelector(
            "#products-error-container"
        );
        if (errorContainer) {
            errorContainer.innerHTML = "";
        }

        if (productIds.length === 0) {
            const errorMessage = isPersian
                ? "حداقل یک محصول باید انتخاب شود"
                : "At least one product must be selected";

            if (errorContainer) {
                errorContainer.innerHTML = `<span class="text-sm text-red-600">${errorMessage}</span>`;
            }
            event.preventDefault();
            return false;
        }

        if (productIds.length > 5) {
            const errorMessage = isPersian
                ? "حداکثر 5 محصول می‌توانید انتخاب کنید"
                : "You can select at most 5 products";

            if (errorContainer) {
                errorContainer.innerHTML = `<span class="text-sm text-red-600">${errorMessage}</span>`;
            }
            event.preventDefault();
            return false;
        }

        // Form is valid, allow submission
        event.target.submit();
    });
});
