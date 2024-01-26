// Function to handle navigation based on the selected option

function navigateToPage() {

  const selectElement = document.getElementById("pageSelect");

  const selectedPage = selectElement.value;

  // check if selectedPage is not empty

  if (selectedPage !== "") {

    window.location.href = selectedPage;

  }

}

// Add event listener to the dropdown menu

document.addEventListener("DOMContentLoaded", function () {

  const selectElement = document.getElementById("pageSelect");

  selectElement.addEventListener("change", navigateToPage);

});
