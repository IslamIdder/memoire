//#region student settings
var studentSettings = document.querySelectorAll('.student-settings');
console.log(studentSettings)
studentSettings.forEach(e => {
    e.addEventListener('mouseenter', function () {
        var parent = e.parentElement;
        parent.classList.add('dossier-etudiant-no-hover')
    })
    e.addEventListener('mouseleave', function () {
        var parent = e.parentElement;
        parent.classList.remove('dossier-etudiant-no-hover')
    })
    e.addEventListener('click', function () {
    })
    window.addEventListener("click", function (event) {
        if (!e.contains(event.target) && !dropDown.contains(event.target)) {
        }
    });
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

//#region dynamic-flex
// var dynamicFlexes = document.querySelectorAll(".dynamic-flex");
// for (i = 0; i < dynamicFlexes.length; i++) {
//     var numChildren = dynamicFlexes[i].childElementCount;
//     var children = dynamicFlexes[i].children;
//     for (j = 0; j < children.length; j++) {
//         children[j].style.setProperty("flex-basis", (100 / numChildren) + "%")
//     }
// }
//#endregion




