function toggleMobileNavigation() {
  const hamburgerMenus = document.querySelectorAll(".hamburger-menu-button");
  const navs = document.querySelectorAll(".navigation");

  hamburgerMenus.forEach((menu) => {
    const open = menu.querySelector('.hamburger-menu-open');
    const close = menu.querySelector('.hamburger-menu-close');

    // Function to update icon visibility based on the 'active' state of navigation
    function updateIconVisibility() {
      navs.forEach((nav) => {
        const isActive = !nav.classList.contains("hidden");
        if (open && close) {
          open.classList.toggle('hidden', isActive);
          close.classList.toggle('hidden', !isActive);
        }
      });
    }

    // Attach event listener if not already initialized
    if (!menu.dataset.initialized) {
      menu.addEventListener("click", function() {
        // Toggle 'active' class on all navigation elements
        navs.forEach((nav) => nav.classList.toggle("hidden"));
        document.body.classList.toggle('overflow-hidden');
        updateIconVisibility();
      });

      // Mark this menu as initialized
      menu.dataset.initialized = "true";
    }

    // Initial update of icon visibility based on the current 'active' state
    updateIconVisibility();
  });
}

toggleMobileNavigation();
