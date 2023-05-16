const arrowButton = document.querySelector("#controller");
const filtersSection = document.querySelector(".filters");
const ticketsSection = document.querySelector("#tickets");
const isFiltersOpen = false;

  arrowButton.addEventListener("click", function() {
    if (!isFiltersOpen) {
      // Show the filters section and position it to overlap the middle column
      filtersSection.style.display = "flex";
      filtersSection.style.gridColumn = "tickets-start/tickets-start"; // Change to "tickets-start/tickets-start"
      ticketsSection.style.marginLeft = "0"; // Change to "marginLeft" and set to "0"
    } else {
      // Hide the filters section and reset its position
      filtersSection.style.display = "none";
      filtersSection.style.gridColumn = "tickets-mid/tickets-mid";
      ticketsSection.style.marginLeft = ""; // Reset the left margin
    }

    isFiltersOpen = !isFiltersOpen;
});

const textarea = document.querySelector("#faq-arrow");

textarea.addEventListener("input", function() {
  // Reset the textarea's height to its scroll height
  textarea.style.height = "auto";
  
  // Set the textarea's height to match its scroll height
  textarea.style.height = textarea.scrollHeight + "px";
});