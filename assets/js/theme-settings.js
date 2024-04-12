function initTheme() {
  colorThemeWatcher();
  let el = document.querySelector('.theme-js');
  if (el.classList.contains('theme-system')) {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      toggleDarkTheme(true);
    }
  }
}

function colorThemeWatcher() {
  try {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        toggleDarkTheme(e.matches ? true : false);
      });
  } catch {
      console.warn('color theme watcher not supported');
  }
}

function toggleDarkTheme(setting) {
  let el = document.querySelector('.theme-js');
  if (setting) {
    el.classList.add('theme-dark');
  } else {
    el.classList.remove('theme-dark');
  }
}

initTheme();