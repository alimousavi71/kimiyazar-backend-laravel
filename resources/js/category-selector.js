/**
 * Category Selector Component
 * Hierarchical category dropdown with client-side search
 */

document.addEventListener("DOMContentLoaded", function () {
    // Initialize all category selectors on the page
    const selectors = document.querySelectorAll(".category-selector-wrapper");

    selectors.forEach((wrapper) => {
        initCategorySelector(wrapper);
    });
});

/**
 * Initialize a category selector
 */
function initCategorySelector(wrapper) {
    const selectorId = wrapper.getAttribute("data-selector-id");
    const button = wrapper.querySelector(".category-selector-button");
    const dropdown = wrapper.querySelector(`[data-dropdown="${selectorId}"]`);
    const searchInput = wrapper.querySelector(`[data-search="${selectorId}"]`);
    const list = wrapper.querySelector(`[data-list="${selectorId}"]`);
    const hiddenSelect = wrapper.querySelector("select");
    const options = list.querySelectorAll(".category-selector-option");
    const textSpan = button.querySelector(".category-selector-text");
    const icon = button.querySelector(".category-selector-icon");

    // Set initial selected value
    const selectedOption = hiddenSelect.querySelector("option:checked");
    if (selectedOption && selectedOption.value) {
        const selectedValue = selectedOption.value;
        const selectedText = selectedOption.textContent.trim();

        // Find the option element to get full path
        const selectedOptionElement = Array.from(options).find(
            (opt) => opt.getAttribute("data-value") === selectedValue
        );

        const displayText = selectedOptionElement
            ? selectedOptionElement.getAttribute("data-full-path") ||
              selectedText
            : selectedText;

        textSpan.textContent = displayText;
        textSpan.classList.remove("text-gray-500");
        textSpan.classList.add("text-gray-900");
    } else {
        textSpan.classList.remove("text-gray-900");
        textSpan.classList.add("text-gray-500");
    }

    // Toggle dropdown
    button.addEventListener("click", function (e) {
        e.stopPropagation();
        const isOpen = !dropdown.classList.contains("hidden");

        // Close all other dropdowns
        document
            .querySelectorAll(".category-selector-dropdown")
            .forEach((dd) => {
                if (dd !== dropdown) {
                    dd.classList.add("hidden");
                }
            });

        if (isOpen) {
            dropdown.classList.add("hidden");
            icon.classList.remove("rotate-180");
        } else {
            dropdown.classList.remove("hidden");
            icon.classList.add("rotate-180");
            searchInput.focus();
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
        if (!wrapper.contains(e.target)) {
            dropdown.classList.add("hidden");
            icon.classList.remove("rotate-180");
        }
    });

    // Handle option selection
    options.forEach((option) => {
        option.addEventListener("click", function () {
            const value = this.getAttribute("data-value");
            const text = this.getAttribute("data-text");
            const fullPath = this.getAttribute("data-full-path") || text;

            // Update hidden select
            hiddenSelect.value = value;
            hiddenSelect.dispatchEvent(new Event("change", { bubbles: true }));

            // Update button text - show full path for child categories
            const displayText = value && fullPath !== text ? fullPath : text;
            textSpan.textContent = displayText;
            if (value) {
                textSpan.classList.remove("text-gray-500");
                textSpan.classList.add("text-gray-900");
            } else {
                textSpan.classList.remove("text-gray-900");
                textSpan.classList.add("text-gray-500");
            }

            // Update visual selection
            options.forEach((opt) => {
                opt.classList.remove("bg-blue-50", "text-blue-700");
            });
            if (value) {
                this.classList.add("bg-blue-50", "text-blue-700");
            }

            // Close dropdown
            dropdown.classList.add("hidden");
            icon.classList.remove("rotate-180");
        });
    });

    // Client-side search
    searchInput.addEventListener("input", function (e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        let visibleCount = 0;

        options.forEach((option) => {
            const categoryName =
                option
                    .querySelector(".category-name")
                    ?.textContent.toLowerCase() || "";
            const fullPath =
                option.getAttribute("data-full-path")?.toLowerCase() ||
                categoryName;
            const matches =
                !searchTerm ||
                categoryName.includes(searchTerm) ||
                fullPath.includes(searchTerm);

            if (matches) {
                option.classList.remove("hidden");
                visibleCount++;
            } else {
                option.classList.add("hidden");
            }
        });

        // Show/hide "no results" message
        let noResultsMsg = list.querySelector(".category-selector-no-results");
        if (visibleCount === 0 && searchTerm) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement("div");
                noResultsMsg.className =
                    "category-selector-no-results p-4 text-center text-sm text-gray-500";
                noResultsMsg.textContent = "No categories found";
                list.appendChild(noResultsMsg);
            }
            noResultsMsg.classList.remove("hidden");
        } else if (noResultsMsg) {
            noResultsMsg.classList.add("hidden");
        }
    });

    // Keyboard navigation
    let selectedIndex = -1;

    searchInput.addEventListener("keydown", function (e) {
        const visibleOptions = Array.from(options).filter(
            (opt) => !opt.classList.contains("hidden")
        );

        if (e.key === "ArrowDown") {
            e.preventDefault();
            selectedIndex = Math.min(
                selectedIndex + 1,
                visibleOptions.length - 1
            );
            updateKeyboardSelection(visibleOptions, selectedIndex);
        } else if (e.key === "ArrowUp") {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateKeyboardSelection(visibleOptions, selectedIndex);
        } else if (e.key === "Enter" && selectedIndex >= 0) {
            e.preventDefault();
            visibleOptions[selectedIndex].click();
        } else if (e.key === "Escape") {
            dropdown.classList.add("hidden");
            icon.classList.remove("rotate-180");
        }
    });

    function updateKeyboardSelection(visibleOptions, index) {
        visibleOptions.forEach((opt, i) => {
            opt.classList.remove("bg-gray-100");
            if (i === index) {
                opt.classList.add("bg-gray-100");
                opt.scrollIntoView({ block: "nearest", behavior: "smooth" });
            }
        });
    }

    // Reset selection on search clear
    searchInput.addEventListener("input", function () {
        selectedIndex = -1;
    });
}
