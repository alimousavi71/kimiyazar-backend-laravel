/**
 * Product Price Management - Inline Editing with Axios
 * Handles inline price editing, individual saves, and bulk updates
 */

document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("products-table-body");
    const syncTodayBtn = document.getElementById("sync-today-btn");

    // Get routes from window object (set in blade template using route() helpers)
    // Routes should be passed from blade template using route() helpers to respect admin prefix config
    // Fallback routes use window.adminPrefix which is set in the admin layout
    const routes = window.productPriceRoutes || {
        updateTemplate: `/${
            window.adminPrefix || "admin"
        }/product-prices/__PRODUCT_ID__`,
        bulkUpdate: `/${
            window.adminPrefix || "admin"
        }/product-prices/bulk-update`,
        syncToday: `/${
            window.adminPrefix || "admin"
        }/product-prices/sync-today`,
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
            // Show validation error (not an axios call, so interceptor won't handle it)
            if (window.Toast) {
                window.Toast.error("Price and currency are required");
            }
            return false;
        }

        try {
            const url = getUpdateRoute(productId);
            // Remove commas and send raw numeric value
            const numericPrice = getNumericValue(price);
            const response = await window.axios.post(url, {
                price: numericPrice,
                currency_code: currencyCode,
            });

            if (response.data && response.data.success !== false) {
                // Success message is handled by axios interceptor
                // Update the current price display
                const row = document.querySelector(
                    `tr[data-product-id="${productId}"]`
                );
                if (row) {
                    // Current price is in the 3rd column (after checkbox and ID)
                    const currentPriceCell =
                        row.querySelector("td:nth-child(3)");
                    if (currentPriceCell) {
                        const currencyLabel =
                            Array.from(row.querySelectorAll("option")).find(
                                (opt) => opt.value === currencyCode
                            )?.textContent || currencyCode;
                        const numericPrice = getNumericValue(price);
                        const formattedPrice =
                            formatNumberWithCommas(numericPrice);
                        currentPriceCell.innerHTML = `
                            <div class="text-sm text-gray-900">
                                ${formattedPrice} ${currencyLabel}
                            </div>
                            <div class="text-xs text-gray-500">
                                ${new Date().toISOString().split("T")[0]}
                            </div>
                        `;
                    }
                }

                return true;
            }
        } catch (error) {
            console.error("Update error:", error);
            // Error toast is handled by axios interceptor
            return false;
        }
    }

    /**
     * Format number with thousand separators
     */
    function formatNumberWithCommas(value) {
        // Remove all non-digit characters
        const numericValue = value.toString().replace(/\D/g, "");
        if (!numericValue) return "";
        // Add thousand separators
        return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    /**
     * Get numeric value from formatted string (remove commas)
     */
    function getNumericValue(value) {
        return value.toString().replace(/,/g, "");
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
                // Current price is in the 3rd column (after checkbox and ID)
                const currentPriceCell = row.querySelector("td:nth-child(3)");
                if (currentPriceCell) {
                    const priceText = currentPriceCell.textContent.trim();
                    const priceMatch = priceText.match(/[\d,]+/);
                    if (priceMatch) {
                        // Keep the formatted value with commas
                        priceInput.value = priceMatch[0];
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
                        // Success handled above
                    });
                }
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
     * Get selected product IDs
     */
    function getSelectedProductIds() {
        const checkboxes = document.querySelectorAll(
            ".product-checkbox:checked"
        );
        return Array.from(checkboxes).map((cb) => parseInt(cb.value));
    }

    /**
     * Update sync button state based on selected products
     */
    function updateSyncButtonState() {
        if (!syncTodayBtn) return;
        const selectedIds = getSelectedProductIds();
        if (selectedIds.length === 0) {
            syncTodayBtn.disabled = true;
        } else {
            syncTodayBtn.disabled = false;
        }
    }

    /**
     * Sync today's prices for selected products using form input values
     */
    async function syncTodayPrices() {
        if (!syncTodayBtn) return;

        const selectedIds = getSelectedProductIds();
        if (selectedIds.length === 0) {
            if (window.Toast) {
                window.Toast.warning(
                    "Please select at least one product to sync"
                );
            }
            return;
        }

        // Get prices and currencies from form inputs for selected products
        const prices = [];
        selectedIds.forEach((productId) => {
            const row = document.querySelector(
                `tr[data-product-id="${productId}"]`
            );
            if (row) {
                const priceInput = row.querySelector(".price-input");
                const currencySelect = row.querySelector(".currency-select");

                if (
                    priceInput &&
                    currencySelect &&
                    priceInput.value &&
                    currencySelect.value
                ) {
                    // Remove commas and get raw numeric value
                    const numericPrice = getNumericValue(priceInput.value);
                    if (numericPrice && numericPrice.length > 0) {
                        prices.push({
                            product_id: productId,
                            price: numericPrice,
                            currency_code: currencySelect.value,
                        });
                    }
                }
            }
        });

        if (prices.length === 0) {
            if (window.Toast) {
                window.Toast.warning(
                    "Please enter price and currency for selected products"
                );
            }
            return;
        }

        syncTodayBtn.disabled = true;
        syncTodayBtn.textContent = "Syncing...";

        try {
            const response = await window.axios.post(routes.syncToday, {
                prices: prices,
            });

            if (response.data && response.data.success !== false) {
                // Success message is handled by axios interceptor
                // Reload page to show updated prices
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } catch (error) {
            console.error("Sync error:", error);
            // Error toast is handled by axios interceptor
        } finally {
            syncTodayBtn.disabled = false;
            if (syncTodayBtn) {
                syncTodayBtn.textContent = "Sync Prices";
            }
        }
    }

    // Sync today button
    if (syncTodayBtn) {
        syncTodayBtn.addEventListener("click", syncTodayPrices);
        updateSyncButtonState(); // Initialize button state
    }

    // Select all checkbox
    const selectAllCheckbox = document.getElementById("select-all-checkbox");
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener("change", function () {
            const productCheckboxes =
                document.querySelectorAll(".product-checkbox");
            productCheckboxes.forEach((cb) => {
                cb.checked = selectAllCheckbox.checked;
            });
            updateSyncButtonState();
        });
    }

    // Individual product checkboxes
    if (tableBody) {
        tableBody.addEventListener("change", function (e) {
            if (e.target.classList.contains("product-checkbox")) {
                updateSyncButtonState();

                // Update select all checkbox state
                if (selectAllCheckbox) {
                    const productCheckboxes =
                        document.querySelectorAll(".product-checkbox");
                    const allChecked = Array.from(productCheckboxes).every(
                        (cb) => cb.checked
                    );
                    const someChecked = Array.from(productCheckboxes).some(
                        (cb) => cb.checked
                    );
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate =
                        someChecked && !allChecked;
                }
            }
        });
    }

    // Format price inputs with thousand separators as user types
    if (tableBody) {
        tableBody.addEventListener("input", function (e) {
            if (e.target.classList.contains("price-input")) {
                const cursorPosition = e.target.selectionStart;
                const oldValue = e.target.value;
                const numericValue = getNumericValue(oldValue);
                const formattedValue = formatNumberWithCommas(numericValue);

                e.target.value = formattedValue;

                // Restore cursor position (adjust for added commas)
                const commaDiff = formattedValue.length - oldValue.length;
                const newPosition = Math.max(0, cursorPosition + commaDiff);
                e.target.setSelectionRange(newPosition, newPosition);
            }
        });

        // Handle paste events
        tableBody.addEventListener("paste", function (e) {
            if (e.target.classList.contains("price-input")) {
                e.preventDefault();
                const pastedText = (
                    e.clipboardData || window.clipboardData
                ).getData("text");
                const numericValue = getNumericValue(pastedText);
                const formattedValue = formatNumberWithCommas(numericValue);
                e.target.value = formattedValue;
            }
        });
    }

    // Pre-fill latest prices on load
    prefillLatestPrices();
});
