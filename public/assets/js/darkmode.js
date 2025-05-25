document.addEventListener("DOMContentLoaded", function () {
  const themeSwitch = document.getElementById("theme-switch");
  const body = document.body;

  // Check for saved theme preference
  if (localStorage.getItem("darkmode") === "enabled") {
      body.classList.add("darkmode");
  }

  themeSwitch.addEventListener("click", function () {
      body.classList.toggle("darkmode");

      // Save theme preference
      if (body.classList.contains("darkmode")) {
          localStorage.setItem("darkmode", "enabled");
      } else {
          localStorage.setItem("darkmode", "disabled");
      }
  });
});