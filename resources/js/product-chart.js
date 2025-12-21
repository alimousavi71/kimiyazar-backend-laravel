import Chart from "chart.js";

// Configure Chart.js to use Vazir font
Chart.defaults.global.defaultFontFamily =
    'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif';
Chart.defaults.global.elements.point.borderWidth = 3;
Chart.defaults.global.elements.point.radius = 4;
Chart.defaults.global.elements.point.hoverRadius = 6;

// Number formatting helper
Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
        c = isNaN((c = Math.abs(c))) ? 2 : c,
        d = d === undefined ? "." : d,
        t = t === undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt((n = Math.abs(Number(n) || 0).toFixed(c)))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    var m =
        s +
        (j ? i.substr(0, j) + t : "") +
        i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +
        (c
            ? d +
              Math.abs(n - i)
                  .toFixed(c)
                  .slice(2)
            : "");
    return m;
};

// Initialize product price chart
function initProductPriceChart(productId, productName) {
    let priceChart = null;
    let currentRange = "1m";

    // Initialize chart with default range
    function initChart() {
        loadChartData(currentRange);
    }

    // Load chart data from API
    function loadChartData(range) {
        const chartLoading = document.getElementById("chartLoading");
        if (chartLoading) {
            chartLoading.style.display = "block";
        }

        // Fetch data from API
        fetch(`/api/products/${productId}/price-history?range=${range}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
            credentials: "same-origin",
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (chartLoading) {
                    chartLoading.style.display = "none";
                }

                if (data.success && data.data) {
                    updateChart(data.data);
                } else {
                    console.error(
                        "Error loading chart data:",
                        data.message || "Unknown error"
                    );
                    // Fallback to empty chart
                    updateChart({
                        labels: [],
                        prices: [],
                        stepSize: undefined,
                        suggestedMin: undefined,
                        suggestedMax: undefined,
                    });
                }
            })
            .catch((error) => {
                if (chartLoading) {
                    chartLoading.style.display = "none";
                }
                console.error("Error fetching price history:", error);
                // Fallback to empty chart
                updateChart({
                    labels: [],
                    prices: [],
                    stepSize: undefined,
                    suggestedMin: undefined,
                    suggestedMax: undefined,
                });
            });
    }

    // Update or create chart
    function updateChart(data) {
        const canvas = document.getElementById("priceChart");
        if (!canvas) {
            console.error("Chart canvas element not found");
            return;
        }

        const ctx = canvas.getContext("2d");
        if (!ctx) {
            console.error("Could not get 2D context from canvas");
            return;
        }

        // Destroy existing chart if it exists
        if (priceChart) {
            priceChart.destroy();
        }

        // Create new chart with updated data
        priceChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: data.labels || [],
                datasets: [
                    {
                        label: productName,
                        backgroundColor: "rgba(34, 197, 94, 0.1)",
                        borderColor: "#22c55e",
                        pointBackgroundColor: "#22c55e",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "#22c55e",
                        fill: true,
                        lineTension: 0.4,
                        data: data.prices || [],
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 10,
                        bottom: 10,
                    },
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        fontFamily:
                            'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                        fontSize: 14,
                        fontColor: "#1f2937",
                        padding: 15,
                        usePointStyle: true,
                    },
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    titleFontFamily:
                        'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                    bodyFontFamily:
                        'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                    footerFontFamily:
                        'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                    titleFontSize: 13,
                    bodyFontSize: 14,
                    footerFontSize: 11,
                    xPadding: 12,
                    yPadding: 12,
                    displayColors: true,
                    borderColor: "#22c55e",
                    borderWidth: 1,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var value = tooltipItem.yLabel;
                            return "قیمت: " + value.formatMoney(0) + " تومان";
                        },
                        footer: function (tooltipItems, data) {
                            return "kimiyazar.com";
                        },
                    },
                },
                scales: {
                    yAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "قیمت (تومان)",
                                fontFamily:
                                    'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                                fontColor: "#22c55e",
                                fontSize: 14,
                                fontStyle: "bold",
                            },
                            gridLines: {
                                display: true,
                                color: "rgba(0, 0, 0, 0.05)",
                                lineWidth: 1,
                            },
                            ticks: {
                                fontFamily:
                                    'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                                fontColor: "#666",
                                fontSize: 12,
                                callback: function (label, index, labels) {
                                    return label.formatMoney(0);
                                },
                                stepSize: data.stepSize || undefined,
                                suggestedMin: data.suggestedMin || undefined,
                                suggestedMax: data.suggestedMax || undefined,
                                beginAtZero: false,
                                maxTicksLimit: 12,
                                padding: 10,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "تاریخ اعلام قیمت",
                                fontFamily:
                                    'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                                fontColor: "#22c55e",
                                fontSize: 14,
                                fontStyle: "bold",
                            },
                            gridLines: {
                                display: true,
                                color: "rgba(0, 0, 0, 0.05)",
                                lineWidth: 1,
                            },
                            ticks: {
                                fontFamily:
                                    'Vazirmatn, "Instrument Sans", ui-sans-serif, system-ui, sans-serif',
                                fontColor: "#666",
                                fontSize: 11,
                                maxRotation: 45,
                                minRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 12,
                            },
                        },
                    ],
                },
            },
        });
    }

    // Initialize chart immediately (don't wait for DOMContentLoaded since function is called after DOM is ready)
    // Use setTimeout to ensure DOM is fully ready
    setTimeout(function () {
        initChart();
        setupRangeButtons();
    }, 100);

    // Setup range button handlers
    function setupRangeButtons() {
        const rangeButtons = document.querySelectorAll(".range-btn");
        rangeButtons.forEach((button) => {
            button.addEventListener("click", function () {
                // Remove active class from all buttons
                rangeButtons.forEach((btn) => {
                    btn.classList.remove(
                        "active",
                        "bg-gradient-to-r",
                        "from-green-500",
                        "to-emerald-400",
                        "text-white"
                    );
                    btn.classList.add("bg-gray-100", "text-gray-700");
                });

                // Add active class to clicked button
                this.classList.add(
                    "active",
                    "bg-gradient-to-r",
                    "from-green-500",
                    "to-emerald-400",
                    "text-white"
                );
                this.classList.remove("bg-gray-100", "text-gray-700");

                // Get range and load data
                currentRange = this.getAttribute("data-range");
                loadChartData(currentRange);
            });
        });
    }
}

// Make Chart and initProductPriceChart available globally
window.Chart = Chart;
window.initProductPriceChart = initProductPriceChart;
