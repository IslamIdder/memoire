
//#region Gear on-click
let settingsContainer = document.querySelectorAll('.dropdown-button')
let dropdownMenus = document.querySelectorAll(".dropdown-menu");
let currentButton = null;
let currentDropdown = null;
settingsContainer.forEach(e => {
    e.addEventListener('click', event => dropDownOnClick(event, e));
});

function dropDownOnClick(event, element) {
    const dropdownButton = element;
    if (currentButton !== null && currentButton !== dropdownButton) {
        currentButton.classList.remove('higher-prio');
        currentDropdown.classList.remove('shown');
    }
    currentButton = dropdownButton;
    currentDropdown = currentButton.children[1];
    currentDropdown.classList.toggle('shown');
    currentButton.classList.toggle('higher-prio');
}
window.addEventListener('click', function (event) {
    const target = event.target;
    if (currentButton !== null && !currentButton.contains(event.target) && !currentDropdown.contains(event.target)) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        const buttons = document.querySelectorAll('.dropdown-button');

        dropdowns.forEach(dropdown => dropdown.classList.remove('shown'));
        buttons.forEach(button => button.classList.remove('higher-prio'));
    }
});

// #endregion

//#region search-bar dynamic search
const searchInput = document.querySelector('.search-bar')
const searchResultsContainer = document.querySelector('.liste-etudiants')
if (searchInput) {
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value;
        var result = document.getElementById('searchType').innerHTML.split("_");
        let type = result[0]
        let id = result[1];
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                searchResultsContainer.innerHTML = this.responseText;
                let settingsContainer = document.querySelectorAll('.dropdown-button')
                settingsContainer.forEach(e => {
                    e.addEventListener('click', event => dropDownOnClick(event, e));
                });
            }
        };
        if (searchTerm.length > 0)
            xhr.open("GET", `/memoire/search.php?q=${searchTerm}&parse=yes&id=${id}&type=${type}`);
        else
            xhr.open("GET", `/memoire/search.php?q=${searchTerm}&parse=no&id=${id}&type=${type}`);
        xhr.send();
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

//#region Confirm display
const myDialog = document.getElementById('myDialog');
const showDialogButton = document.querySelectorAll(".showDialogButton");
const closeDialogButton = document.getElementById('closeDialog');

showDialogButton.forEach(e => {
    e.addEventListener('click', () => {
        myDialog.showModal();
    })
});

closeDialogButton.addEventListener('click', () => {
    myDialog.close();
});

//#endregion