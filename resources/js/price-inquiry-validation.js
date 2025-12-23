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

    // Products validation - create a hidden field for validation
    const productsValidationInput = document.createElement("input");
    productsValidationInput.type = "hidden";
    productsValidationInput.id = "products-validation-field";
    productsValidationInput.name = "products-validation";
    priceInquiryForm.appendChild(productsValidationInput);

    // Add validation rule that checks products dynamically
    validation.addField("#products-validation-field", [
        {
            rule: "customRegexp",
            value: () => {
                const productInputs = Array.from(
                    priceInquiryForm.querySelectorAll(
                        'input[name="products[]"]'
                    )
                );
                const productIds = productInputs
                    .map((input) => input.value)
                    .filter((value) => value && value.trim() !== "");

                // Must have at least 1 and at most 5 products
                return productIds.length >= 1 && productIds.length <= 5;
            },
            errorMessage: isPersian
                ? "حداقل یک محصول و حداکثر 5 محصول باید انتخاب شود"
                : "You must select at least 1 product and at most 5 products",
        },
    ]);

    // Also add a custom error display handler for products
    const validateProducts = () => {
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

            const errorContainer = priceInquiryForm.querySelector(
                "#products-error-container"
            );
            if (errorContainer) {
                errorContainer.innerHTML = `<span class="text-sm text-red-600">${errorMessage}</span>`;
            }
            return false;
        }

        if (productIds.length > 5) {
            const errorMessage = isPersian
                ? "حداکثر 5 محصول می‌توانید انتخاب کنید"
                : "You can select at most 5 products";

            const errorContainer = priceInquiryForm.querySelector(
                "#products-error-container"
            );
            if (errorContainer) {
                errorContainer.innerHTML = `<span class="text-sm text-red-600">${errorMessage}</span>`;
            }
            return false;
        }

        return true;
    };

    // Validate products on form submission
    validation.onSuccess((event) => {
        if (!validateProducts()) {
            event.preventDefault();
            return false;
        }
        // Form is valid, allow submission
        return true;
    });
});
