/**
 * Reusable script for handling form submission with tag attachment
 *
 * Usage:
 * initFormWithTags({
 *     formId: 'content-create-form',
 *     tagManagerSelector: '[id^="tag-manager-"]',
 *     tagableType: 'App\\Models\\Content',
 *     tagableId: null, // For create forms, use null. For edit forms, use the entity ID
 *     redirectUrl: '/admin/contents', // Optional - should use route() helper in blade template to respect admin prefix config
 *     successMessage: 'Content created successfully', // Optional
 *     onSuccess: function(response, entityId) { // custom logic },
 *     onError: function(error) { // custom logic }
 * });
 */

window.initFormWithTags = function (config) {
    const {
        formId,
        tagManagerSelector = '[id^="tag-manager-"]',
        tagableType,
        tagableId = null,
        redirectUrl = null,
        successMessage = null,
        errorMessage = null,
        onSuccess = null,
        onError = null,
    } = config;

    // Function to initialize the form handler
    function initializeFormHandler() {
        const form = document.getElementById(formId);
        const tagManagerElement = document.querySelector(tagManagerSelector);

        if (!form) {
            console.warn(`Form with ID "${formId}" not found`);
            return;
        }

        // Check if this is an edit form (PUT/PATCH) - if so, handle submission independently
        const method =
            form.querySelector('input[name="_method"]')?.value || "POST";
        const isUpdate = method === "PUT" || method === "PATCH";

        // For create forms, just set up the attachTagsToEntity function for form-with-photos.js to call
        if (!isUpdate) {
            window.attachTagsToEntity = async function (entityId) {
                if (!entityId || !tagManagerElement || !tagableType) {
                    return;
                }

                const tagManager = Alpine.$data(tagManagerElement);
                if (tagManager && typeof tagManager.attachTags === "function") {
                    try {
                        // Always call attachTags to sync tags (even if empty array to clear existing tags)
                        await tagManager.attachTags(tagableType, entityId);
                    } catch (attachError) {
                        console.warn("Failed to attach tags:", attachError);
                        if (onError && typeof onError === "function") {
                            onError(attachError);
                        }
                    }
                }
            };
            return;
        }

        // For edit forms, handle form submission independently
        // Use capture phase to catch the event early
        const submitHandler = async function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton
                ? submitButton.innerHTML
                : "";

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<span class="animate-spin">⏳</span> در حال پردازش...';
            }

            try {
                // Ensure _method is set in FormData for Laravel method spoofing
                if (!formData.has("_method")) {
                    formData.append("_method", "PUT");
                }
                // Submit form via axios using POST with _method=PUT (Laravel method spoofing)
                const response = await window.axios.post(
                    form.action,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                if (
                    response.data &&
                    (response.data.success !== false ||
                        response.status === 201 ||
                        response.status === 200)
                ) {
                    // Get the entity ID from response or use provided tagableId
                    const finalEntityId =
                        response.data.data?.id ||
                        response.data.id ||
                        tagableId ||
                        (response.headers?.location
                            ? response.headers.location.split("/").pop()
                            : null);

                    // Attach photos if photo manager exists (for edit forms)
                    if (
                        finalEntityId &&
                        typeof window.attachPhotosToEntity === "function"
                    ) {
                        try {
                            await window.attachPhotosToEntity(finalEntityId);
                        } catch (attachError) {
                            console.warn(
                                "Failed to attach photos:",
                                attachError
                            );
                        }
                    }

                    // Attach tags if tag manager exists (always sync, even if empty to clear existing tags)
                    if (finalEntityId && tagManagerElement && tagableType) {
                        const tagManager = Alpine.$data(tagManagerElement);

                        if (
                            tagManager &&
                            typeof tagManager.attachTags === "function"
                        ) {
                            try {
                                await tagManager.attachTags(
                                    tagableType,
                                    finalEntityId
                                );
                            } catch (attachError) {
                                console.error(
                                    "Failed to attach tags:",
                                    attachError
                                );
                                // Don't fail the whole operation if tag attachment fails
                            }
                        }
                    }

                    // Call custom success callback if provided
                    if (onSuccess && typeof onSuccess === "function") {
                        onSuccess(response, finalEntityId);
                    } else if (redirectUrl) {
                        // Default: redirect to provided URL
                        window.location.href = redirectUrl;
                    }
                } else {
                    throw new Error(
                        response.data?.message || "Form submission failed"
                    );
                }
            } catch (error) {
                console.error("Form submission error:", error);

                // Handle validation errors
                if (error.response?.data?.errors) {
                    Object.keys(error.response.data.errors).forEach((field) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add("border-red-500");
                            // Remove error class after 3 seconds
                            setTimeout(() => {
                                input.classList.remove("border-red-500");
                            }, 3000);
                        }
                    });
                }

                // Call custom error callback if provided
                if (onError && typeof onError === "function") {
                    onError(error);
                }

                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }
        };

        // Add listener with capture to catch it early
        form.addEventListener("submit", submitHandler, { capture: true });
    }

    // Check if DOM is already loaded, otherwise wait for DOMContentLoaded
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initializeFormHandler);
    } else {
        // DOM is already loaded, run immediately
        initializeFormHandler();
    }
};
