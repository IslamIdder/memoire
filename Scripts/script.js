//#region student settings
var studentSettings = document.querySelectorAll('.student-settings');
studentSettings.forEach(e => {


})
//#endregion

//#region Gear on-click
const settingsButton = document.querySelector(".user-settings")
const dropDown = document.querySelector(".dropdown-menu")
settingsButton.addEventListener('click', function () {
    dropDown.classList.toggle('shown');
})
window.addEventListener("click", function (event) {
    if (!settingsButton.contains(event.target) && !dropDown.contains(event.target)) {
        dropDown.classList.remove("shown");
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