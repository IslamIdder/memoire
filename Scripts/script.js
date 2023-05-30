
//#region Gear on-click
const settingsButtons = document.querySelectorAll(".dropdown-button");
const dropdownMenus = document.querySelectorAll(".dropdown-menu");
let currentButton = null;
let currentDropdown = null;

settingsButtons.forEach(button => {
    button.addEventListener('click', () => {
        currentButton = button;
        currentDropdown = button.children[1];
        dropdownMenus.forEach(d => {
            if (d !== currentDropdown) {
                d.parentElement.classList.remove('higher-prio')
                d.classList.remove("shown")
            }
        })
        currentButton.classList.toggle("higher-prio");
        currentDropdown.classList.toggle("shown");
    });
});

window.addEventListener("click", function (event) {
    if (currentButton !== null && !currentButton.contains(event.target) && !currentDropdown.contains(event.target)) {
        currentDropdown.classList.remove("shown");
        currentButton.classList.remove("higher-prio");
    }
});

// #endregion

//#region search-bar dynamic search
const searchInput = document.querySelector('.search-bar')
const searchResultsContainer = document.querySelector('.liste-etudiants')
if (searchInput) {
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value;
        var classeID = document.getElementById('classeID').innerHTML;
        if (searchTerm.length > 0) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResultsContainer.innerHTML = this.responseText;
                }
            };
            xhr.open("GET", `/memoire/search.php?q=${searchTerm}&parse=yes&id_classe=${classeID}`);
            xhr.send();
        }
        else {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResultsContainer.innerHTML = this.responseText;
                }
            };
            xhr.open("GET", `/memoire/search.php?q=${searchTerm}&parse=no&id_classe=${classeID}`);
            xhr.send();
        }
    });
}
//#endregion

//#region tables display
const tables = document.querySelectorAll('.table-med');
for (let i = 2; i <= 11; i++) {
    for (let j = 1; j <= i; j++) {
        const selector = `.t-${i}>*:nth-child(${i}n + ${j})`;
        const rule = `grid-row: ${j}/${j + 1};`;
        const style = document.createElement('style');
        style.innerHTML = `${selector} { ${rule} }`;
        document.head.appendChild(style);
    }
}
//#endregion