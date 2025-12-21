/**
 * Reusable Delete Handler for Tables
 *
 * Usage:
 * 1. Initialize Alpine store for your model (e.g., deleteAdmin, deleteUser, etc.)
 * 2. Use the deleteHandler function in your Alpine component
 * 3. Use the delete-confirmation-modal Blade component
 *
 * Example:
 * ```javascript
 * document.addEventListener('alpine:init', () => {
 *     Alpine.store('deleteAdmin', {
 *         id: null,
 *         name: null,
 *         set(id, name) {
 *             this.id = id;
 *             this.name = name;
 *         }
 *     });
 * });
 *
 * function adminDeleteData() {
 *     return deleteHandler({
 *         storeName: 'deleteAdmin',
 *         routeName: 'admin.admins.destroy',
 *         modalId: 'delete-admin-modal',
 *         rowSelector: (id) => `tr[data-admin-id="${id}"]`
 *     });
 * }
 * ```
 */

/**
 * Creates a reusable delete handler function
 * @param {Object} config - Configuration object
 * @param {string} config.storeName - Name of the Alpine store (e.g., 'deleteAdmin')
 * @param {string} config.routeUrl - Full route URL with __ID__ placeholder (e.g., '/admin/admins/__ID__')
 *                                     Should use route() helper in blade template to respect admin prefix config
 * @param {string} config.modalId - Modal ID for opening/closing
 * @param {Function} config.rowSelector - Function that returns CSS selector for the row element
 * @param {Function} [config.onSuccess] - Optional callback after successful deletion
 * @param {Function} [config.onError] - Optional callback after error
 * @returns {Object} Alpine.js data object
 */
window.deleteHandler = function (config) {
    const {
        storeName,
        routeUrl,
        modalId,
        rowSelector,
        onSuccess = null,
        onError = null,
    } = config;

    if (!storeName || !routeUrl || !modalId || !rowSelector) {
        console.error("deleteHandler: Missing required configuration");
        return { deleting: false };
    }

    return {
        deleting: false,

        deleteItem() {
            this.deleting = true;
            const store = Alpine.store(storeName);

            if (!store || !store.id) {
                console.error(
                    `deleteHandler: Store "${storeName}" not found or id is missing`
                );
                this.deleting = false;
                return;
            }

            const itemId = store.id;
            const deleteUrl = routeUrl.replace("__ID__", itemId);

            window.axios
                .delete(deleteUrl, {
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then((response) => {
                    // Reset deleting state
                    this.deleting = false;

                    // Close modal
                    this.$dispatch("close-modal", modalId);

                    // Remove the row from table with fade out animation
                    const selector =
                        typeof rowSelector === "function"
                            ? rowSelector(itemId)
                            : rowSelector.replace("__ID__", itemId);

                    const row = document.querySelector(selector);
                    if (row) {
                        row.style.transition = "opacity 0.3s ease-out";
                        row.style.opacity = "0";
                        setTimeout(() => {
                            row.remove();

                            // Check if table is empty and reload if needed
                            const tbody = document.querySelector("tbody");
                            if (
                                tbody &&
                                tbody.querySelectorAll("tr").length === 0
                            ) {
                                window.location.reload();
                            }
                        }, 300);
                    } else {
                        // Fallback: reload if row not found
                        window.location.reload();
                    }

                    // Call custom success callback if provided
                    if (onSuccess && typeof onSuccess === "function") {
                        onSuccess(response, itemId);
                    }
                })
                .catch((error) => {
                    this.deleting = false;

                    // Call custom error callback if provided
                    if (onError && typeof onError === "function") {
                        onError(error);
                    }
                    // Error toast is handled by axios interceptor
                });
        },
    };
};

/**
 * Helper function to initialize Alpine store for delete operations
 * @param {string} storeName - Name of the store
 */
window.initDeleteStore = function (storeName) {
    // Initialize immediately if Alpine is already loaded
    if (window.Alpine && window.Alpine.store) {
        if (!Alpine.store(storeName)) {
            Alpine.store(storeName, {
                id: null,
                name: null,
                set(id, name) {
                    this.id = id;
                    this.name = name;
                },
            });
        }
    }

    // Also listen for alpine:init event for when Alpine loads later
    document.addEventListener("alpine:init", () => {
        if (!Alpine.store(storeName)) {
            Alpine.store(storeName, {
                id: null,
                name: null,
                set(id, name) {
                    this.id = id;
                    this.name = name;
                },
            });
        }
    });
};
