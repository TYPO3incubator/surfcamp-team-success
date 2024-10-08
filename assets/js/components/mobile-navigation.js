function toggleMobileNavigation() {
    const menu = document.querySelector(".hamburger-menu-button");
    const nav = document.querySelector(".navigation");
    let menuOpen = false;

    const open = menu.querySelector('.hamburger-menu-open');
    const close = menu.querySelector('.hamburger-menu-close');

    // Function to update icon visibility based on the 'active' state of navigation
    function updateIconVisibility() {
        const isActive = !nav.classList.contains("hidden");
        if (open && close) {
            open.classList.toggle('hidden', isActive);
            close.classList.toggle('hidden', !isActive);
        }
    }

    // Attach event listener if not already initialized
    if (!menu.dataset.initialized) {
        menu.addEventListener("click", function () {
            // Toggle 'active' class on all navigation elements
            nav.classList.toggle("hidden")
            document.body.classList.toggle('overflow-hidden');
            updateIconVisibility();
            menuOpen = !menuOpen;
        });

        // Mark this menu as initialized
        menu.dataset.initialized = "true";
    }

    // Initial update of icon visibility based on the current 'active' state
    updateIconVisibility();

    // close menu on esc
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (menuOpen) {
                nav.classList.add("hidden")
                document.body.classList.remove('overflow-hidden');
                updateIconVisibility();
                menuOpen = !menuOpen;
            }
        }
    });
}

toggleMobileNavigation();