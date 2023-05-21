

const btn = document.querySelectorAll(".option");
const teeth = document.querySelectorAll('.tooth');
const selection = document.querySelector('.selection');
const id_etudiant = document.getElementById('id_etudiant');
const id = id_etudiant.getAttribute('data-id');
var current_tooth = 0;
var tooth_array = new Array(32);
var current;
var mutex = 0;
shown = false;
teeth.forEach(e => {
    e.addEventListener('mouseover', function () {
        const bbox = e.getBoundingClientRect();
        const centerX = bbox.left + bbox.width / 2;
        const centerY = bbox.top + bbox.height / 2;
        window.onmousemove = function (j) {
            x = j.pageX;
            y = j.pageY;
            document.getElementById('x').style.top = centerY + 'px'
            document.getElementById('x').style.left = centerX + 'px'
        }
        document.getElementById('x').style.opacity = 1;
    })
    e.addEventListener("mouseleave", function () {
        document.getElementById('x').style.opacity = 0;
    })
    e.addEventListener("click", function () {

        current_tooth = parseInt(e.id.split("_")[1]);
        if (e.classList.contains("absent") || e.classList.contains("cavitated") || e.classList.contains("obtured")) {
            e.classList.remove("cavitated");
            e.classList.remove("obtured");
            e.classList.remove("absent");
            tooth_array[current_tooth - 1] = null
            current_tooth = 0;
            return;
        }
        const bbox = e.getBoundingClientRect();
        const centerX = bbox.left + bbox.width / 2;
        const centerY = bbox.top + bbox.height / 2;
        shown = true;
        selection.style.setProperty("display", "flex")


        const sbbox = selection.getBoundingClientRect();
        const scenterY = sbbox.height / 2;
        selection.style.top = (centerY - scenterY) + 'px'
        selection.style.left = (centerX + 10) + 'px'
    })
})
btn.forEach(btn => {
    btn.addEventListener('click', function () {
        current = document.querySelector("#" + "tooth_" + current_tooth)//#tooth_1
        if (btn.id == "cavity") {
            current.classList.remove("absent");
            current.classList.remove("obtured");
            current.classList.add("cavitated");
            tooth_array[current_tooth - 1] = "cavitée"
        }
        else if (btn.id == "absent") {
            current.classList.remove("cavitated");
            current.classList.remove("obtured");
            current.classList.add("absent");
            tooth_array[current_tooth - 1] = "absente"
        }
        else if (btn.id == "obtured") {
            current.classList.remove("absent");
            current.classList.remove("cavitated");
            current.classList.add("obtured");
            tooth_array[current_tooth - 1] = "obturée"
        }
        selection.style.setProperty("display", "none")
        current_tooth = 0;
    })
})
document.addEventListener("click", function (event) {
    var remove = true;
    teeth.forEach(function (element) {
        if (element.contains(event.target)) {
            remove = false;
        }
    })
    if (remove === true) {
        selection.style.setProperty("display", "none")
    }
});

function setMyArrayValue() {
    document.getElementById('tooth').value = JSON.stringify(tooth_array);
}