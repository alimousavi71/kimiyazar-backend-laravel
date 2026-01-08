/**
 * Persian Date Picker for Modal Forms
 * Using @majidh1/jalalidatepicker
 * Backend handles all date conversion
 */

import "@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css";

// Import the date picker - it creates a global jalaliDatepicker object
import "@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js";

function init() {
    // Check if jalaliDatepicker is available
    if (typeof window.jalaliDatepicker === "undefined") {
        console.error("jalaliDatepicker is not available");
        return;
    }

    // Initialize date picker for all inputs with data-jdp attribute
    window.jalaliDatepicker.startWatch({
        time: false,
        dateSeparator: "/",
    });
}

// Wait for DOM to be ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}
