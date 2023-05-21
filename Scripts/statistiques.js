var wilayas = ["Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "MSila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane"];


var currentDate = new Date().toISOString().split("T")[0];
document.getElementById("finish_date").value = currentDate;
var buttons = document.querySelectorAll('.chart-type');
var allCharts = document.querySelectorAll(".all-chart")
var wilayaCharts = document.querySelectorAll(".wilaya-chart")
var illness = document.querySelector('#illnesses')
buttons.forEach(btn => {
    btn.addEventListener('click', function () {
        buttons.forEach(b => {
            b.classList.remove('current-chart');
        })
        btn.classList.add('current-chart');
        if (btn.id === 'mapBtn') {
            document.querySelectorAll('.chart').forEach(e => {
                e.style.setProperty('display', "none");
            })
            document.getElementById('map').style.setProperty("display", "block");
        }
        else if (btn.id === 'lollipopBtn') {
            document.querySelectorAll('.chart').forEach(e => {
                e.style.setProperty('display', "none");
            })
            document.getElementById('lolipop').style.setProperty("display", "block");
        }
        else if (btn.id === 'pieBtn') {
            document.querySelectorAll('.chart').forEach(e => {
                e.style.setProperty('display', "none");
            })
            document.getElementById('pie').style.setProperty("display", "block");
        }
        else if (btn.id === 'histoBtn') {
            document.querySelectorAll('.chart').forEach(e => {
                e.style.setProperty('display', "none");
            })
            document.getElementById('histo').style.setProperty("display", "block");
        }
    })
})

function getCurrentChart() {
    var current_chart = document.querySelector('.current-chart');
    if (current_chart.id === 'choroplethBtn') {
        document.getElementById('map').display = "block";
    }
    else if (current_chart.id === 'lollipopBtn') {
        document.getElementById('lolipop').display = "block";
    }
}

var wilaya = document.querySelector('#wilaya');

function checkCurrent() {
    if (!(wilaya.value === "all")) {
        wilayaCharts.forEach(e => {
            e.style.setProperty("display", "flex");
        })
        allCharts.forEach(e => {
            e.style.setProperty("display", "none");
        })
        document.getElementById('pieBtn').classList.add('current-chart');
        document.getElementById('pie').style.setProperty("display", "block");
        illness.style.setProperty("display", "none");
    }
    else {
        wilayaCharts.forEach(e => {
            e.style.setProperty("display", "none");
        })
        allCharts.forEach(e => {
            e.style.setProperty("display", "flex");
        })
        document.getElementById('mapBtn').classList.add('current-chart');
        document.getElementById('map').style.setProperty("display", "block");
        illness.style.setProperty("display", "block");
    }
}
checkCurrent();

wilaya.addEventListener('change', function () {
    checkCurrent();
})



function colorMap(data) {
    var minMaxVals = d3.extent(data, function (d) {
        return d.value;
    });
    var minVal = minMaxVals[0];
    var maxVal = minMaxVals[1];
    var colorGradient = d3.schemeBlues[7];
    var gradient = d3.scaleLinear()
        .domain(d3.range(0, 7).map(function (i) {
            return minVal + (i / 6) * (maxVal - minVal);
        }))
        .range(colorGradient);
    for (var i = 0; i < data.length; i++) {
        d3.selectAll(`[data-num-wilaya="${data[i].num}"]`)
            .attr("fill", function (d) {
                var regionVal = data[i].value;
                return gradient(regionVal);
            })
            .attr("data-nbr-cas", function (d) {
                return data[i].value;
            })
        // d3.selectAll(`#${data[i].wilaya}`)
        //     .attr("fill", function (d) {
        //         var regionVal = data[i].value;
        //         return gradient(regionVal);
        //     })
        //     .attr("data-nbr-cas", function (d) {
        //         return data[i].value;
        //     })
        //     .attr("data-nom-wilaya", function () {
        //         return this.id.replace(/_/g, ' ');
        //     });
    }
}
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('myForm').addEventListener('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "stats-query", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                var data_final = [];
                for (var i = 0; i < 48; i++) {
                    data_final[i] = {
                        wilaya: wilayas[i],
                        num: i,
                        value: 0
                    }
                }
                for (var i = 0; i < wilayas.length; i++) {
                    for (var j = 0; j < data.length; j++) {
                        if (wilayas[i] === data[j].wilaya) {
                            data_final[i].value = parseInt(data[j].number);
                        }
                    }
                }
                console.log(data_final)
                colorMap(data_final);
                var lolipop = document.querySelector('#lolipop')
                lolipop.innerHTML = ""
                createLolipopChart(data_final)
            } else {
                console.error(xhr.responseText);
            }
        };
        xhr.onerror = function () {
            // Handle any network errors
            console.error('An error occurred during the AJAX request.');
        };
        xhr.send(formData);
    });
});