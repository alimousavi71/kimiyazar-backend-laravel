/**
 * Axios Interceptors for Centralized Request/Response Handling
 */

// Wait for axios to be available before setting up interceptors
function setupInterceptors() {
    if (typeof window === "undefined" || typeof window.axios === "undefined") {
        // Retry after a short delay
        setTimeout(setupInterceptors, 50);
        return;
    }

    // Get CSRF token from meta tag
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    }

    // Request Interceptor
    window.axios.interceptors.request.use(
        function (config) {
            // Add loading indicator
            if (config.showLoading !== false) {
                // You can add a global loading indicator here
                document.body.classList.add("loading");
            }

            // Log request (only in development)
            if (process.env.NODE_ENV === "development") {
                console.log("🚀 Axios Request:", {
                    method: config.method?.toUpperCase(),
                    url: config.url,
                    data: config.data,
                });
            }

            return config;
        },
        function (error) {
            // Handle request error
            document.body.classList.remove("loading");
            console.error("❌ Request Error:", error);
            return Promise.reject(error);
        }
    );

    // Response Interceptor
    window.axios.interceptors.response.use(
        function (response) {
            // Remove loading indicator
            document.body.classList.remove("loading");

            // Log response (only in development)
            if (process.env.NODE_ENV === "development") {
                console.log("✅ Axios Response:", {
                    status: response.status,
                    url: response.config.url,
                    data: response.data,
                });
            }

            // Handle success messages from server
            if (response.data?.message && window.Toast) {
                window.Toast.success(response.data.message);
            }

            return response;
        },
        function (error) {
            // Remove loading indicator
            document.body.classList.remove("loading");

            // Handle different error types
            if (error.response) {
                // Server responded with error status
                const { status, data } = error.response;

                // Log error
                console.error("❌ Response Error:", {
                    status,
                    url: error.config?.url,
                    data,
                });

                // Handle different HTTP status codes
                switch (status) {
                    case 401:
                        // Unauthorized - redirect to login
                        if (window.Toast) {
                            window.Toast.error(
                                "Session expired. Please login again."
                            );
                        }
                        setTimeout(() => {
                            window.location.href = "/login";
                        }, 2000);
                        break;

                    case 403:
                        // Forbidden
                        if (window.Toast) {
                            window.Toast.error(
                                "You do not have permission to perform this action."
                            );
                        }
                        break;

                    case 404:
                        // Not Found
                        if (window.Toast) {
                            window.Toast.warning(
                                "The requested resource was not found."
                            );
                        }
                        break;

                    case 422:
                        // Validation Error - Concatenate all errors
                        const errors = data?.errors || {};
                        const errorMessages = Object.values(errors).flat();

                        if (errorMessages.length > 0) {
                            // Format all errors as a readable list
                            let allErrors;
                            if (errorMessages.length === 1) {
                                allErrors = errorMessages[0];
                            } else {
                                // Format as bullet list for multiple errors
                                allErrors = errorMessages
                                    .map((msg, index) => `${index + 1}. ${msg}`)
                                    .join("\n");
                            }

                            if (window.Toast) {
                                // Show all errors in a single toast
                                window.Toast.error(allErrors);
                            }
                        } else {
                            // Fallback if no specific errors found
                            const message =
                                data?.message ||
                                "Validation failed. Please check your input.";
                            if (window.Toast) {
                                window.Toast.error(message);
                            }
                        }
                        break;

                    case 429:
                        // Too Many Requests
                        if (window.Toast) {
                            window.Toast.warning(
                                "Too many requests. Please try again later."
                            );
                        }
                        break;

                    case 500:
                    case 503:
                        // Server Error
                        if (window.Toast) {
                            window.Toast.error(
                                "Server error. Please try again later."
                            );
                        }
                        break;

                    default:
                        // Other errors
                        const message =
                            data?.message ||
                            `An error occurred (${status}). Please try again.`;
                        if (window.Toast) {
                            window.Toast.error(message);
                        }
                }
            } else if (error.request) {
                // Request was made but no response received
                console.error("❌ Network Error:", error.request);
                if (window.Toast) {
                    window.Toast.error(
                        "Network error. Please check your connection."
                    );
                }
            } else {
                // Something else happened
                console.error("❌ Error:", error.message);
                if (window.Toast) {
                    window.Toast.error("An unexpected error occurred.");
                }
            }

            return Promise.reject(error);
        }
    );

    console.log("✅ Axios interceptors initialized");
}

// Initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", setupInterceptors);
} else {
    setupInterceptors();
}
