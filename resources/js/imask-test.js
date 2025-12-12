import IMask from "imask";

// Wait for DOM to be ready
document.addEventListener("DOMContentLoaded", function () {
    // Phone Number Mask
    const phoneInput = document.getElementById("phone-input");
    if (phoneInput) {
        const phoneMask = IMask(phoneInput, {
            mask: "(000) 000-0000",
        });

        phoneInput.addEventListener("input", () => {
            updateResult("phone", phoneMask.value);
        });
    }

    // Date Mask
    const dateInput = document.getElementById("date-input");
    if (dateInput) {
        const dateMask = IMask(dateInput, {
            mask: "MM/DD/YYYY",
            blocks: {
                MM: {
                    mask: IMask.MaskedRange,
                    from: 1,
                    to: 12,
                },
                DD: {
                    mask: IMask.MaskedRange,
                    from: 1,
                    to: 31,
                },
                YYYY: {
                    mask: IMask.MaskedRange,
                    from: 1900,
                    to: 2999,
                },
            },
        });

        dateInput.addEventListener("input", () => {
            updateResult("date", dateMask.value);
        });
    }

    // Credit Card Mask
    const creditCardInput = document.getElementById("credit-card-input");
    if (creditCardInput) {
        const creditCardMask = IMask(creditCardInput, {
            mask: "0000 0000 0000 0000",
        });

        creditCardInput.addEventListener("input", () => {
            updateResult("credit-card", creditCardMask.value);
        });
    }

    // Currency Mask
    const currencyInput = document.getElementById("currency-input");
    if (currencyInput) {
        const currencyMask = IMask(currencyInput, {
            mask: "$num",
            blocks: {
                num: {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: ",",
                    padFractionalZeros: true,
                    normalizeZeros: true,
                    radix: ".",
                    mapToRadix: ["."],
                },
            },
        });

        currencyInput.addEventListener("input", () => {
            updateResult("currency", currencyMask.value);
        });
    }

    // IP Address Mask
    const ipInput = document.getElementById("ip-input");
    if (ipInput) {
        const ipMask = IMask(ipInput, {
            mask: "000.000.000.000",
        });

        ipInput.addEventListener("input", () => {
            updateResult("ip", ipMask.value);
        });
    }

    // Time Mask
    const timeInput = document.getElementById("time-input");
    if (timeInput) {
        const timeMask = IMask(timeInput, {
            mask: "HH:MM",
            blocks: {
                HH: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 23,
                },
                MM: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 59,
                },
            },
        });

        timeInput.addEventListener("input", () => {
            updateResult("time", timeMask.value);
        });
    }

    // License Plate Mask (Custom Pattern)
    const licensePlateInput = document.getElementById("license-plate-input");
    if (licensePlateInput) {
        const licensePlateMask = IMask(licensePlateInput, {
            mask: "AAA-0000",
        });

        licensePlateInput.addEventListener("input", () => {
            updateResult("license-plate", licensePlateMask.value);
        });
    }

    // Dynamic Mask (Phone or Email)
    const dynamicInput = document.getElementById("dynamic-input");
    if (dynamicInput) {
        let dynamicMask = null;

        dynamicInput.addEventListener("input", (e) => {
            const value = e.target.value;

            // Check if it looks like an email
            if (value.includes("@")) {
                if (dynamicMask) dynamicMask.destroy();
                // No mask for email, just let it be
                updateResult("dynamic", value);
            } else {
                // Apply phone mask
                if (
                    !dynamicMask ||
                    dynamicMask.masked.mask !== "(000) 000-0000"
                ) {
                    if (dynamicMask) dynamicMask.destroy();
                    dynamicMask = IMask(dynamicInput, {
                        mask: "(000) 000-0000",
                    });
                }
                updateResult("dynamic", dynamicMask.value);
            }
        });
    }

    // Update results display
    function updateResult(type, value) {
        const resultsDiv = document.getElementById("test-results");
        if (!resultsDiv) return;

        const existingResult = resultsDiv.querySelector(
            `[data-type="${type}"]`
        );
        const resultText = `<strong>${type
            .replace("-", " ")
            .replace(/\b\w/g, (l) => l.toUpperCase())}:</strong> ${
            value || "(empty)"
        }`;

        if (existingResult) {
            existingResult.innerHTML = resultText;
        } else {
            const resultElement = document.createElement("p");
            resultElement.setAttribute("data-type", type);
            resultElement.className = "text-sm text-gray-700";
            resultElement.innerHTML = resultText;
            resultsDiv.appendChild(resultElement);
        }
    }
});
