/**
 * Product Price Management - Inline Editing with Axios
 * Handles inline price editing, individual saves, and bulk updates
 */

document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("products-table-body");
    const bulkSaveBtn = document.getElementById("bulk-save-btn");
    const syncTodayBtn = document.getElementById("sync-today-btn");

    // Get routes from window object (set in blade template)
    const routes = window.productPriceRoutes || {
        updateTemplate: "/admin/product-prices/__PRODUCT_ID__",
        bulkUpdate: "/admin/product-prices/bulk-update",
        syncToday: "/admin/product-prices/sync-today",
    };

    function getUpdateRoute(productId) {
        return routes.updateTemplate.replace("__PRODUCT_ID__", productId);
    }

    // Track changed rows
    const changedRows = new Set();

    /**
     * Update individual product price
     */
    async function updateProductPrice(productId, price, currencyCode) {
        if (!price || !currencyCode) {
            if (window.Toast) {
                window.Toast.error("Price and currency are required");
            }
            return false;
        }

        try {
            const url = getUpdateRoute(productId);
            const response = await window.axios.post(url, {
                price: parseFloat(price),
                currency_code: currencyCode,
            });

            if (response.data && response.data.success !== false) {
                if (window.Toast) {
                    const message =
                        response.data?.data?.message ||
                        response.data?.message ||
                        "Price updated successfully";
                    window.Toast.success(message);
                }

                // Update the current price display
                const row = document.querySelector(
                    `tr[data-product-id="${productId}"]`
                );
                if (row) {
                    const currentPriceCell =
                        row.querySelector("td:nth-child(2)");
                    if (currentPriceCell) {
                        const currencyLabel =
                            Array.from(row.querySelectorAll("option")).find(
                                (opt) => opt.value === currencyCode
                            )?.textContent || currencyCode;
                        currentPriceCell.innerHTML = `
                            <div class="text-sm text-gray-900">
                                ${parseFloat(
                                    price
                                ).toLocaleString()} ${currencyLabel}
                            </div>
                            <div class="text-xs text-gray-500">
                                ${new Date().toISOString().split("T")[0]}
                            </div>
                        `;
                    }
                }

                changedRows.delete(productId);
                updateBulkSaveButton();
                return true;
            }
        } catch (error) {
            console.error("Update error:", error);
            if (window.Toast) {
                const errorMsg =
                    error.response?.data?.message ||
                    error.message ||
                    "Failed to update price";
                window.Toast.error(errorMsg);
            }
            return false;
        }
    }

    /**
     * Bulk update all changed prices
     */
    async function bulkUpdatePrices() {
        const prices = [];
        const rows = tableBody.querySelectorAll("tr[data-product-id]");

        rows.forEach((row) => {
            const productId = row.getAttribute("data-product-id");
            const priceInput = row.querySelector(".price-input");
            const currencySelect = row.querySelector(".currency-select");

            if (
                priceInput &&
                currencySelect &&
                priceInput.value &&
                currencySelect.value
            ) {
                prices.push({
                    product_id: parseInt(productId),
                    price: parseFloat(priceInput.value),
                    currency_code: currencySelect.value,
                });
            }
        });

        if (prices.length === 0) {
            if (window.Toast) {
                window.Toast.warning("No changes to save");
            }
            return;
        }

        bulkSaveBtn.disabled = true;
        bulkSaveBtn.textContent = "Saving...";

        try {
            const response = await window.axios.post(routes.bulkUpdate, {
                prices,
            });

            if (response.data && response.data.success !== false) {
                if (window.Toast) {
                    const message =
                        response.data?.data?.message ||
                        response.data?.message ||
                        "Prices updated successfully";
                    window.Toast.success(message);
                }

                // Reload page to show updated prices
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } catch (error) {
            console.error("Bulk update error:", error);
            if (window.Toast) {
                const errorMsg =
                    error.response?.data?.message ||
                    error.message ||
                    "Failed to update prices";
                window.Toast.error(errorMsg);
            }
        } finally {
            bulkSaveBtn.disabled = false;
            bulkSaveBtn.textContent = "Save All Changes";
            changedRows.clear();
            updateBulkSaveButton();
        }
    }

    /**
     * Mark row as changed
     */
    function markRowChanged(productId) {
        changedRows.add(productId);
        updateBulkSaveButton();
    }

    /**
     * Update bulk save button state
     */
    function updateBulkSaveButton() {
        if (changedRows.size > 0) {
            bulkSaveBtn.disabled = false;
            bulkSaveBtn.classList.remove("opacity-50", "cursor-not-allowed");
        } else {
            bulkSaveBtn.disabled = true;
            bulkSaveBtn.classList.add("opacity-50", "cursor-not-allowed");
        }
    }

    /**
     * Pre-fill prices from latest prices (for new date creation)
     */
    function prefillLatestPrices() {
        const rows = tableBody.querySelectorAll("tr[data-product-id]");
        rows.forEach((row) => {
            const productId = row.getAttribute("data-product-id");
            const priceInput = row.querySelector(".price-input");
            const currencySelect = row.querySelector(".currency-select");

            // If inputs are empty, pre-fill from current price display
            if (priceInput && !priceInput.value) {
                const currentPriceCell = row.querySelector("td:nth-child(2)");
                if (currentPriceCell) {
                    const priceText = currentPriceCell.textContent.trim();
                    const priceMatch = priceText.match(/[\d,]+/);
                    if (priceMatch) {
                        priceInput.value = priceMatch[0].replace(/,/g, "");
                    }
                }
            }
        });
    }

    // Event Listeners

    // Individual save buttons
    if (tableBody) {
        tableBody.addEventListener("click", function (e) {
            if (e.target.classList.contains("save-price-btn")) {
                const productId = parseInt(
                    e.target.getAttribute("data-product-id")
                );
                const row = e.target.closest("tr");
                const priceInput = row.querySelector(".price-input");
                const currencySelect = row.querySelector(".currency-select");

                if (priceInput && currencySelect) {
                    e.target.disabled = true;
                    e.target.textContent = "Saving...";

                    updateProductPrice(
                        productId,
                        priceInput.value,
                        currencySelect.value
                    ).then((success) => {
                        e.target.disabled = false;
                        e.target.textContent = "Save";
                        if (success) {
                            changedRows.delete(productId);
                            updateBulkSaveButton();
                        }
                    });
                }
            }
        });

        // Track changes on input fields
        tableBody.addEventListener("input", function (e) {
            if (
                e.target.classList.contains("price-input") ||
                e.target.classList.contains("currency-select")
            ) {
                const productId = parseInt(
                    e.target.closest("tr").getAttribute("data-product-id")
                );
                markRowChanged(productId);
            }
        });

        // Allow Enter key to save
        tableBody.addEventListener("keydown", function (e) {
            if (
                e.key === "Enter" &&
                (e.target.classList.contains("price-input") ||
                    e.target.classList.contains("currency-select"))
            ) {
                e.preventDefault();
                const row = e.target.closest("tr");
                const productId = parseInt(row.getAttribute("data-product-id"));
                const priceInput = row.querySelector(".price-input");
                const currencySelect = row.querySelector(".currency-select");
                const saveBtn = row.querySelector(".save-price-btn");

                if (saveBtn && priceInput && currencySelect) {
                    saveBtn.click();
                }
            }
        });
    }

    /**
     * Sync today's prices
     */
    async function syncTodayPrices() {
        if (!syncTodayBtn) return;

        syncTodayBtn.disabled = true;
        syncTodayBtn.textContent = "Syncing...";

        try {
            const response = await window.axios.post(routes.syncToday);

            if (response.data && response.data.success !== false) {
                if (window.Toast) {
                    const message =
                        response.data?.data?.message ||
                        response.data?.message ||
                        "Prices synced successfully";
                    window.Toast.success(message);
                }

                // Reload page to show updated prices
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } catch (error) {
            console.error("Sync error:", error);
            if (window.Toast) {
                const errorMsg =
                    error.response?.data?.message ||
                    error.message ||
                    "Failed to sync prices";
                window.Toast.error(errorMsg);
            }
        } finally {
            syncTodayBtn.disabled = false;
            if (syncTodayBtn) {
                syncTodayBtn.textContent = "Sync Today's Prices";
            }
        }
    }

    // Bulk save button
    if (bulkSaveBtn) {
        bulkSaveBtn.addEventListener("click", bulkUpdatePrices);
        updateBulkSaveButton(); // Initialize button state
    }

    // Sync today button
    if (syncTodayBtn) {
        syncTodayBtn.addEventListener("click", syncTodayPrices);
    }

    // Pre-fill latest prices on load
    prefillLatestPrices();
});
