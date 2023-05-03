

const states = document.querySelectorAll('path');
states.forEach(e => {
    e.addEventListener('mouseover', function () {
        e.style.fill = "#fff";
    })
})
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
        if (searchTerm.length > 0) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResultsContainer.innerHTML = this.responseText;
                }
            };
            xhr.open("GET", `/memoire/search.php?q=${searchTerm}&parse=yes`);
            xhr.send();
        }
        else {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResultsContainer.innerHTML = this.responseText;
                }
            };
            xhr.open("GET", `/memoire/search.php?q=${searchTerm}&parse=no`);
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


//#region Medical folder scrolling
const dossier = document.querySelector('.slider')
var bodyWidth = document.querySelector('.dossier').offsetWidth;
window.addEventListener('resize', function () {
    bodyWidth = document.querySelector('.dossier').offsetWidth;
    dossier.style.setProperty("--body-width", bodyWidth + "px")
});
dossier.style.setProperty("--body-width", bodyWidth + "px")
const moveNext = document.querySelector('.move-next');
const movePrevious = document.querySelector('.move-previous');
document.addEventListener("click", e => {
    let icon
    if (e.target.matches(".move")) {
        icon = e.target
    } else {
        icon = e.target.closest(".move")
    }
    if (icon != null) {
        oniconClick(icon)
    }
})
function oniconClick(icon) {
    const dossierIndex = parseInt(
        getComputedStyle(dossier).getPropertyValue("--dossier-index")
    )
    if (icon.classList.contains("move-previous")) {
        if (dossierIndex - 1 >= 0) {
            dossier.style.setProperty("--dossier-index", dossierIndex - 1)
        }
        else {
            dossier.style.setProperty("--dossier-index", dossier.childElementCount - 1)
        }

    }
    if (icon.classList.contains("move-next")) {
        if (dossierIndex < dossier.childElementCount - 1) {
            dossier.style.setProperty("--dossier-index", dossierIndex + 1)
        }
        else {
            dossier.style.setProperty("--dossier-index", 0)
        }
    }
}
//#endregion