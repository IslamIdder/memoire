//#region Medical folder scrolling
const dossier = document.querySelector('.slider')
var bodyWidth = document.querySelector('.dossier').offsetWidth;
const numSlides = dossier.children.length;
const sliderIconsContainer = document.querySelector('.slider-icons');
console.log(sliderIconsContainer)

for (let i = 0; i < numSlides; i++) {
    const sliderIcon = document.createElement('span');
    sliderIcon.classList.add('slider-icon')
    sliderIconsContainer.appendChild(sliderIcon);
}
const sliderIcons = document.querySelectorAll('.slider-icon');
var Index = parseInt(
    getComputedStyle(dossier).getPropertyValue("--dossier-index")
)
sliderIcons[Index].classList.add("active")

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
    var dossierIndex = parseInt(
        getComputedStyle(dossier).getPropertyValue("--dossier-index")
    )
    getComputedStyle(dossier).getPropertyValue("--dossier-index")
    if (icon.classList.contains("move-previous")) {
        if (dossierIndex - 1 >= 0) {
            dossierIndex = dossierIndex - 1;
            dossier.style.setProperty("--dossier-index", dossierIndex)
        }
        else {
            dossierIndex = dossier.childElementCount - 1;
            dossier.style.setProperty("--dossier-index", dossierIndex)
        }
    }
    if (icon.classList.contains("move-next")) {
        if (dossierIndex < dossier.childElementCount - 1) {
            dossierIndex = dossierIndex + 1;
            dossier.style.setProperty("--dossier-index", dossierIndex)
        }
        else {
            dossierIndex = 0;
            dossier.style.setProperty("--dossier-index", dossierIndex)
        }
    }
    sliderIcons.forEach((btn, index) => {
        if (index === dossierIndex) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}
document.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowRight')
        oniconClick(moveNext)
    else if (event.key === 'ArrowLeft')
        oniconClick(movePrevious)

})
document.addEventListener('wheel', function (event) {
    var delta = event.deltaY || event.detail || (-event.wheelDelta);
    var scrollDirection = delta > 0 ? 'down' : 'up';
    if (scrollDirection === 'up') {
        oniconClick(movePrevious)
    } else {
        oniconClick(moveNext)
    }
    event.preventDefault();
})
document.querySelectorAll('date').forEach(d => {
    d.addEventListener('focus', function () {
        this.type = 'date';
    })
    d.addEventListener('blur', function () {
        this.type = 'date';
    })
})
//#endregion