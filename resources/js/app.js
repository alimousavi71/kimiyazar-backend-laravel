import "./bootstrap";
import "./delete-handler";
import "./dropdown-menu";
import Alpine from "alpinejs";

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

/**
 * Toast Notification System
 */
class Toast {
    static show(message, type = "info", duration = 5000) {
        const container = document.getElementById("toast-container");
        if (!container) return;

        // Detect direction
        const isRtl = document.documentElement.dir === "rtl";
        const translateClass = isRtl ? "-translate-x-full" : "translate-x-full";

        const toast = document.createElement("div");
        toast.className = `p-4 rounded-lg shadow-lg flex items-center gap-3 min-w-[300px] max-w-md transform transition-all duration-300 ${translateClass} opacity-0`;

        // Set colors based on type
        const colors = {
            success: "bg-green-100 text-green-800 border border-green-300",
            danger: "bg-red-100 text-red-800 border border-red-300",
            warning: "bg-yellow-100 text-yellow-800 border border-yellow-300",
            info: "bg-blue-100 text-blue-800 border border-blue-300",
        };

        toast.className += ` ${colors[type] || colors.info}`;

        // Icon
        const icons = {
            success: "✓",
            danger: "✕",
            warning: "⚠",
            info: "ℹ",
        };

        // Format message to handle line breaks
        const formattedMessage = message
            .split("\n")
            .map((line) =>
                line.trim()
                    ? `<div class="text-sm font-medium">${line}</div>`
                    : ""
            )
            .join("");

        toast.innerHTML = `
            <span class="font-semibold text-lg">${
                icons[type] || icons.info
            }</span>
            <div class="flex-1 space-y-1">
                ${formattedMessage}
            </div>
            <button class="text-current opacity-70 hover:opacity-100 transition-opacity" onclick="this.parentElement.remove()">
                <span class="sr-only">Close</span>
                <span aria-hidden="true">&times;</span>
            </button>
        `;

        container.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.remove(translateClass, "opacity-0");
            toast.classList.add("translate-x-0", "opacity-100");
        }, 10);

        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                toast.classList.add(translateClass, "opacity-0");
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }
    }

    static success(message, duration) {
        this.show(message, "success", duration);
    }

    static error(message, duration) {
        this.show(message, "danger", duration);
    }

    static warning(message, duration) {
        this.show(message, "warning", duration);
    }

    static info(message, duration) {
        this.show(message, "info", duration);
    }
}

// Make Toast available globally
window.Toast = Toast;

/**
 * Modal Helper Functions
 */
function setupModalHandlers() {
    // Handle modal open/close events
    document.addEventListener("open-modal", function (e) {
        const modalId = e.detail || e.target?.getAttribute("data-modal-id");
        if (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Try Alpine.js first
                if (window.Alpine && Alpine.$data) {
                    try {
                        const modalData = Alpine.$data(modal);
                        if (modalData && typeof modalData.open === "boolean") {
                            modalData.open = true;
                            return;
                        }
                    } catch (error) {
                        console.warn(
                            "Alpine.js not ready, using fallback method"
                        );
                    }
                }

                // Fallback: dispatch event to window for Alpine listeners
                const event = new CustomEvent("open-modal", {
                    detail: modalId,
                    bubbles: true,
                    cancelable: true,
                });
                window.dispatchEvent(event);
                document.dispatchEvent(event);
            }
        }
    });

    document.addEventListener("close-modal", function (e) {
        const modalId = e.detail || e.target?.getAttribute("data-modal-id");
        if (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Try Alpine.js first
                if (window.Alpine && Alpine.$data) {
                    try {
                        const modalData = Alpine.$data(modal);
                        if (modalData && typeof modalData.open === "boolean") {
                            modalData.open = false;
                            return;
                        }
                    } catch (error) {
                        console.warn(
                            "Alpine.js not ready, using fallback method"
                        );
                    }
                }

                // Fallback: dispatch event to window for Alpine listeners
                const event = new CustomEvent("close-modal", {
                    detail: modalId,
                    bubbles: true,
                    cancelable: true,
                });
                window.dispatchEvent(event);
                document.dispatchEvent(event);
            }
        }
    });
}

// Initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", setupModalHandlers);
} else {
    setupModalHandlers();
}

// Handle sidebar toggle
document.addEventListener("toggle-sidebar", function (e) {
    // Find the sidebar element
    const sidebar = document.querySelector('nav[x-data*="open"]');
    if (sidebar) {
        // Detect direction
        const isRtl = document.documentElement.dir === "rtl";
        const hiddenClass = isRtl ? "translate-x-full" : "-translate-x-full";

        if (window.Alpine) {
            try {
                const sidebarData = Alpine.$data(sidebar);
                if (sidebarData && typeof sidebarData.open === "boolean") {
                    sidebarData.open = !sidebarData.open;
                }
            } catch (error) {
                console.error("Error toggling sidebar with Alpine:", error);
                // Fallback: toggle manually
                const isOpen = sidebar.classList.contains("translate-x-0");
                if (isOpen) {
                    sidebar.classList.remove("translate-x-0");
                    sidebar.classList.add(hiddenClass);
                } else {
                    sidebar.classList.remove(hiddenClass);
                    sidebar.classList.add("translate-x-0");
                }
            }
        } else {
            // Fallback if Alpine.js is not loaded
            const isOpen = !sidebar.classList.contains(hiddenClass);
            if (isOpen) {
                sidebar.classList.add(hiddenClass);
            } else {
                sidebar.classList.remove(hiddenClass);
            }
        }
    }
});

// Handle filter sidebar open/close events (backup for Alpine.js)
window.addEventListener("open-filter-sidebar", function (e) {
    const sidebarId = e.detail;
    if (sidebarId) {
        const sidebar = document.getElementById(sidebarId);
        if (sidebar && window.Alpine) {
            try {
                const sidebarData = Alpine.$data(sidebar);
                if (sidebarData && typeof sidebarData.open === "boolean") {
                    sidebarData.open = true;
                }
            } catch (error) {
                console.error("Error opening filter sidebar:", error);
            }
        }
    }
});

window.addEventListener("close-filter-sidebar", function (e) {
    const sidebarId = e.detail;
    if (sidebarId) {
        const sidebar = document.getElementById(sidebarId);
        if (sidebar && window.Alpine) {
            try {
                const sidebarData = Alpine.$data(sidebar);
                if (sidebarData && typeof sidebarData.open === "boolean") {
                    sidebarData.open = false;
                }
            } catch (error) {
                console.error("Error closing filter sidebar:", error);
            }
        }
    }
});

/**
 * Form Validation Helper
 */
function validateForm(form) {
    const inputs = form.querySelectorAll(
        "input[required], select[required], textarea[required]"
    );
    let isValid = true;

    inputs.forEach((input) => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add("border-red-500");

            // Remove error class after user starts typing
            input.addEventListener(
                "input",
                function () {
                    this.classList.remove("border-red-500");
                },
                { once: true }
            );
        } else {
            input.classList.remove("border-red-500");
        }
    });

    return isValid;
}

// Make validateForm available globally
window.validateForm = validateForm;

/**
 * Initialize tooltips and other interactive elements
 */
document.addEventListener("DOMContentLoaded", function () {
    // Add any additional initialization code here
    console.log("Admin Panel initialized");
});
