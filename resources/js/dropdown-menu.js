import { createPopper } from "@popperjs/core";

/**
 * Initialize dropdown menus with Popper.js positioning
 */
document.addEventListener("DOMContentLoaded", function () {
    // Initialize all dropdown menus
    initializeDropdownMenus();
});

/**
 * Initialize dropdown menus using Alpine.js and Popper.js
 */
function initializeDropdownMenus() {
    // This will be called by Alpine.js components
    window.initDropdownPopper = function (
        triggerElement,
        dropdownElement,
        placement = "bottom-end"
    ) {
        if (!triggerElement || !dropdownElement) return null;

        // Use Popper.js directly with standard modifiers
        return createPopper(triggerElement, dropdownElement, {
            placement: placement,
            modifiers: [
                {
                    name: "offset",
                    options: {
                        offset: [0, 8],
                    },
                },
                {
                    name: "preventOverflow",
                    options: {
                        boundary: "viewport",
                        padding: 8,
                    },
                },
                {
                    name: "flip",
                    options: {
                        fallbackPlacements: [
                            "top-end",
                            "bottom-start",
                            "top-start",
                            "bottom-end",
                        ],
                    },
                },
            ],
        });
    };
}
