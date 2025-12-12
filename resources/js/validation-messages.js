/**
 * Centralized Validation Messages for Just-Validate
 * Supports Persian (fa) and English (en) languages
 * Uses dynamic message generation to avoid hardcoded messages
 */

// Only keep truly unique messages that can't be generated dynamically
const uniqueMessages = {
    en: {
        "Please confirm your password": "Please confirm your password",
        "Passwords do not match": "Passwords do not match",
        "Form validated successfully!": "Form validated successfully!",
        "You must accept the terms and conditions":
            "You must accept the terms and conditions",
        "Username can only contain letters, numbers, and underscores":
            "Username can only contain letters, numbers, and underscores",
        "This email is already taken": "This email is already taken",
        "You must be at least 18 years old":
            "You must be at least 18 years old",
        "Please enter a valid age": "Please enter a valid age",
        "Please enter a valid URL": "Please enter a valid URL",
    },
    fa: {
        "Please confirm your password": "لطفاً رمز عبور را تأیید کنید",
        "Passwords do not match": "رمزهای عبور مطابقت ندارند",
        "Form validated successfully!": "فرم با موفقیت اعتبارسنجی شد!",
        "You must accept the terms and conditions":
            "شما باید شرایط و قوانین را بپذیرید",
        "Username can only contain letters, numbers, and underscores":
            "نام کاربری فقط می‌تواند شامل حروف، اعداد و زیرخط باشد",
        "This email is already taken": "این ایمیل قبلاً استفاده شده است",
        "You must be at least 18 years old":
            "شما باید حداقل 18 سال سن داشته باشید",
        "Please enter a valid age": "لطفاً یک سن معتبر وارد کنید",
        "Please enter a valid URL": "لطفاً یک آدرس معتبر وارد کنید",
    },
};

/**
 * Get unique validation messages based on current locale
 * @param {string} locale - Current locale (e.g., 'fa', 'en')
 * @returns {Object} Messages object for the specified locale
 */
export function getValidationMessages(locale = null) {
    // Detect locale from HTML lang attribute if not provided
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }

    const isPersian = locale === "fa" || locale === "ar";
    return isPersian ? uniqueMessages.fa : uniqueMessages.en;
}

/**
 * Get a single validation message (for unique messages only)
 * @param {string} key - Message key
 * @param {string} locale - Optional locale override
 * @returns {string} Translated message
 */
export function getValidationMessage(key, locale = null) {
    const messages = getValidationMessages(locale);
    return messages[key] || key;
}

/**
 * Helper function to create a message getter function
 * @param {string} locale - Optional locale override
 * @returns {Function} Function that takes a key and returns the message
 */
export function createMessageGetter(locale = null) {
    const messages = getValidationMessages(locale);
    return (key) => messages[key] || key;
}

/**
 * Field name translations for common fields
 * Maps English field names to their translations
 */
const fieldTranslations = {
    en: {
        "First name": "First name",
        "Last name": "Last name",
        Email: "Email",
        Password: "Password",
        Username: "Username",
        "Phone number": "Phone number",
        Age: "Age",
        Website: "Website",
        Message: "Message",
        Bio: "Bio",
    },
    fa: {
        "First name": "نام",
        "Last name": "نام خانوادگی",
        Email: "ایمیل",
        Password: "رمز عبور",
        Username: "نام کاربری",
        "Phone number": "شماره تلفن",
        Age: "سن",
        Website: "وب‌سایت",
        Message: "پیام",
        Bio: "بیوگرافی",
    },
};

/**
 * Get translated field name
 * @param {string} fieldName - Field name in English
 * @param {string} locale - Optional locale override
 * @returns {string} Translated field name
 */
function getTranslatedFieldName(fieldName, locale = null) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translations = isPersian
        ? fieldTranslations.fa
        : fieldTranslations.en;
    return translations[fieldName] || fieldName;
}

/**
 * Generate "Field is required" message dynamically
 * @param {string} fieldName - Field name (e.g., "First name", "Email")
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function fieldRequired(fieldName, locale = null) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translatedField = getTranslatedFieldName(fieldName, locale);

    if (isPersian) {
        return `${translatedField} الزامی است`;
    }
    return `${translatedField} is required`;
}

/**
 * Generate "Field must be at least X characters" message dynamically
 * @param {string} fieldName - Field name (e.g., "First name", "Password")
 * @param {number} minLength - Minimum length
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function fieldMinLength(fieldName, minLength, locale = null) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translatedField = getTranslatedFieldName(fieldName, locale);

    if (isPersian) {
        return `${translatedField} باید حداقل ${minLength} کاراکتر باشد`;
    }
    return `${translatedField} must be at least ${minLength} characters`;
}

/**
 * Generate "Field must be less than X characters" message dynamically
 * @param {string} fieldName - Field name (e.g., "First name", "Username")
 * @param {number} maxLength - Maximum length
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function fieldMaxLength(fieldName, maxLength, locale = null) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translatedField = getTranslatedFieldName(fieldName, locale);

    if (isPersian) {
        return `${translatedField} باید کمتر از ${maxLength} کاراکتر باشد`;
    }
    return `${translatedField} must be less than ${maxLength} characters`;
}

/**
 * Generate "Field must be between X and Y characters" message dynamically
 * @param {string} fieldName - Field name (e.g., "Message")
 * @param {number} minLength - Minimum length
 * @param {number} maxLength - Maximum length
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function fieldBetweenLength(
    fieldName,
    minLength,
    maxLength,
    locale = null
) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translatedField = getTranslatedFieldName(fieldName, locale);

    if (isPersian) {
        return `${translatedField} باید بین ${minLength} تا ${maxLength} کاراکتر باشد`;
    }
    return `${translatedField} must be between ${minLength} and ${maxLength} characters`;
}

/**
 * Generate "Field is invalid" message dynamically
 * @param {string} fieldName - Field name (e.g., "Email", "Phone number")
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function fieldInvalid(fieldName, locale = null) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translatedField = getTranslatedFieldName(fieldName, locale);

    if (isPersian) {
        return `${translatedField} نامعتبر است`;
    }
    return `${translatedField} is invalid`;
}

/**
 * Generate "Field must be a number" message dynamically
 * @param {string} fieldName - Field name (e.g., "Age")
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function fieldMustBeNumber(fieldName, locale = null) {
    if (!locale) {
        locale = document.documentElement.lang?.split("-")[0] || "en";
    }
    const isPersian = locale === "fa" || locale === "ar";
    const translatedField = getTranslatedFieldName(fieldName, locale);

    if (isPersian) {
        return `${translatedField} باید یک عدد باشد`;
    }
    return `${translatedField} must be a number`;
}

/**
 * Generate "Please confirm your password" message
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function confirmPassword(locale = null) {
    return getValidationMessage("Please confirm your password", locale);
}

/**
 * Generate "Passwords do not match" message
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function passwordsDoNotMatch(locale = null) {
    return getValidationMessage("Passwords do not match", locale);
}

/**
 * Generate "Form validated successfully!" message
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function formValidatedSuccessfully(locale = null) {
    return getValidationMessage("Form validated successfully!", locale);
}

/**
 * Generate "You must accept the terms and conditions" message
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function mustAcceptTerms(locale = null) {
    return getValidationMessage(
        "You must accept the terms and conditions",
        locale
    );
}

/**
 * Generate "Username can only contain letters, numbers, and underscores" message
 * @param {string} locale - Optional locale override
 * @returns {string} Validation message
 */
export function usernameFormat(locale = null) {
    return getValidationMessage(
        "Username can only contain letters, numbers, and underscores",
        locale
    );
}
