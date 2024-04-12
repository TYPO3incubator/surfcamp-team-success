const Theme = {
  DARK: 'theme-dark',
  LIGHT: 'theme-light'
};

const systemSettingDark = window.matchMedia("(prefers-color-scheme: dark)");
const themeToggle = document.querySelector("[data-theme-toggle]");
const onButton = themeToggle.querySelector('.on')
const offButton = themeToggle.querySelector('.off')

function getCurrentTheme() {
  const storedTheme = localStorage.getItem("theme");
  if (storedTheme !== null) {
    return storedTheme;
  }
  return systemSettingDark.matches ? Theme.DARK : Theme.LIGHT;
}

let currentThemeSetting = getCurrentTheme();

function applyTheme(theme) {
  const el = document.querySelector('.theme-js');
  el.classList.remove(Theme.DARK, Theme.LIGHT); // Remove both to ensure clean state
  el.classList.add(theme);

  const onButton = document.querySelector('.on');
  const offButton = document.querySelector('.off');
  if (theme === Theme.DARK) {
    onButton.classList.remove('hidden');
    offButton.classList.add('hidden');
  } else {
    onButton.classList.add('hidden');
    offButton.classList.remove('hidden');
  }
}

function changeTheme(theme, saveToLocalStorage = true) {
  if (theme === undefined) {
    theme = currentThemeSetting === Theme.DARK ? Theme.LIGHT : Theme.DARK;
  }

  if (saveToLocalStorage) {
    localStorage.setItem("theme", theme);
  }

  currentThemeSetting = theme;
  applyTheme(theme);
}

themeToggle.addEventListener("click", function(e) {
  e.preventDefault();
  changeTheme();
});

function initTheme() {
  applyTheme(currentThemeSetting);
  colorThemeWatcher();
  updateLabelVisibility(currentThemeSetting);
}

function colorThemeWatcher() {
  systemSettingDark.addEventListener('change', e => {
    if (localStorage.getItem("theme") == null) {
      const newTheme = e.matches ? Theme.DARK : Theme.LIGHT;
      changeTheme(newTheme, false);
    }
  });
}

function updateLabelVisibility(theme) {
  const onButton = document.querySelector('.on');
  const offButton = document.querySelector('.off');
  if (theme === Theme.DARK) {
    onButton.classList.remove('hidden');
    offButton.classList.add('hidden');
  } else {
    onButton.classList.add('hidden');
    offButton.classList.remove('hidden');
  }
}

initTheme();
