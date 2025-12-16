/**
 * Reusable script for handling form submission with photo attachment
 *
 * Usage:
 * <script>
 *     initFormWithPhotos({
 *         formId: 'content-create-form',
 *         photoManagerSelector: '[id^="photo-manager-"]',
 *         photoableType: 'App\\Models\\Content',
 *         redirectUrl: '/admin/contents',
 *         successMessage: 'Content created successfully'
 *     });
 * </script>
 */

window.initFormWithPhotos = function (config) {
    const {
        formId,
        photoManagerSelector = '[id^="photo-manager-"]',
        photoableType,
        redirectUrl,
        successMessage = null,
        onSuccess = null,
        onError = null,
    } = config;

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById(formId);
        const photoManagerElement =
            document.querySelector(photoManagerSelector);

        if (!form) {
            console.warn(`Form with ID "${formId}" not found`);
            return;
        }

        form.addEventListener("submit", async function (e) {
            e.preventDefault();

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
                // Submit form via axios
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
                    // Get the created entity ID from response
                    const entityId =
                        response.data.data?.id ||
                        response.data.id ||
                        (response.headers?.location
                            ? response.headers.location.split("/").pop()
                            : null);

                    // Attach photos if photo manager exists and has photos
                    if (entityId && photoManagerElement && photoableType) {
                        const photoManager = Alpine.$data(photoManagerElement);
                        if (
                            photoManager &&
                            photoManager.photos &&
                            photoManager.photos.length > 0
                        ) {
                            try {
                                await photoManager.attachPhotos(
                                    photoableType,
                                    entityId
                                );
                            } catch (attachError) {
                                console.warn(
                                    "Failed to attach photos:",
                                    attachError
                                );
                                // Don't fail the whole operation if photo attachment fails
                            }
                        }
                    }

                    // Attach tags if tag manager exists (for create forms)
                    if (typeof window.attachTagsToEntity === "function") {
                        try {
                            await window.attachTagsToEntity(entityId);
                        } catch (attachError) {
                            console.warn("Failed to attach tags:", attachError);
                            // Don't fail the whole operation if tag attachment fails
                        }
                    }

                    // Call custom success callback if provided
                    if (onSuccess && typeof onSuccess === "function") {
                        onSuccess(response, entityId);
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
        });
    });
};
