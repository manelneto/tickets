document.addEventListener("DOMContentLoaded", function() {
  var arrowButton = document.querySelector("#controller");
  var filtersSection = document.querySelector(".filters");
  var ticketsSection = document.querySelector("#tickets");
  var isFiltersOpen = false;

  arrowButton.addEventListener("click", function() {
    if (!isFiltersOpen) {
      // Show the filters section and position it to overlap the middle column
      filtersSection.style.display = "flex";
      filtersSection.style.gridColumn = "tickets-start/tickets-end";
      filtersSection.style.justifyContent = "center"; // Align filters to the center horizontally
      ticketsSection.style.marginRight = "0"; // Remove right margin to make room for the sidebar
    } else {
      // Hide the filters section and reset its position
      filtersSection.style.display = "none";
      filtersSection.style.gridColumn = "tickets-mid/tickets-mid";
      filtersSection.style.justifyContent = ""; // Reset the justify-content property
      ticketsSection.style.marginRight = ""; // Reset the right margin
    }

    isFiltersOpen = !isFiltersOpen;
  });
});













