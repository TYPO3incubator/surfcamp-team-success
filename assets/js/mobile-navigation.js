
toggleMobileNavigation()

function toggleMobileNavigation() {
  const hamburgerMenu = document.querySelector(".hambuger-menu-button");
  const nav = document.querySelector(".navigation");

  if (hamburgerMenu != null) {
    hamburgerMenu.addEventListener("click", () => {
      nav.classList.toggle("active")
    });
  }
}
