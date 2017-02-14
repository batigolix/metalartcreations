/* Toggles between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function openResponsiveMenu() {
  var x = document.getElementById("responsive-menu");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
