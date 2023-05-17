var buttons = document.querySelectorAll('.chart-type');
buttons.forEach(btn => {
    btn.addEventListener('click', function () {
        buttons.forEach(b => {
            b.classList.remove('current-chart');
            b.classList.remove('current-chart');
        })
        btn.classList.add('current-chart');
        if (btn.id === 'choroplethBtn') {
            document.getElementById('lolipop').style.setProperty("display", "none");
            document.getElementById('map').style.setProperty("display", "block");
        }
        else if (btn.id === 'lollipopBtn') {
            document.getElementById('map').style.setProperty("display", "none");
            document.getElementById('lolipop').style.setProperty("display", "block");
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
// else if (current_chart.id === 'pieBtn') {

// }