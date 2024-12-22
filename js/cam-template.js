document.addEventListener("DOMContentLoaded", function () {
    if (typeof $ === "undefined") {
        console.error("jQuery is not loaded. Please check script dependencies.");
        return;
    }

    $.ajax({
        dataType: "json",
        async: false,
        url: "https://softwareapi.org/api/api.loadModels.php",
        success: function (data) {
            console.log("Data fetched successfully:", data);
            // Data processing...
        },
        error: function () {
            console.error("Error fetching data from the API.");
        },
    });
});
