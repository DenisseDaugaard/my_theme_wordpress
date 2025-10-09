document.addEventListener("DOMContentLoaded", darkMode);
function darkMode() {
    const rootElm = document.documentElement;
    const darkModeBtn = document.querySelector("#dark-mode-toggle");
    console.log(rootElm);
    

    // Get saved mode from localStorage or use browser preference
    const savedMode = JSON.parse(localStorage.getItem("isDarkMode"));
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    let darkState = typeof savedMode === "boolean" ? savedMode : prefersDark;

    // Apply initial state
    setDarkMode(darkState, false);

    // Toggle on button click
    darkModeBtn.addEventListener("click", () => {
        darkState = !darkState;
        setDarkMode(darkState, true);
    });

    function setDarkMode(isDark, save = true) {
        rootElm.setAttribute("data-dark", isDark);
        darkModeBtn.innerHTML = isDark ? "<i class=\"fa-solid fa-sun\" style=\"color: #ff5a6e;\"></i>" : "<i class=\"fa-solid fa-moon\" style=\"color: #B197FC;\"></i>";

        if (save) {
            localStorage.setItem("isDarkMode", JSON.stringify(isDark));
        }
    }
}
