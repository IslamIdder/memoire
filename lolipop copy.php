<html lang="en">
<div id="state-name" style="position:absolute;opacity:0;">
    <div>name</div>
    <div class="">Nombre de cas:

    </div>
</div>
<div id="my_dataviz"></div>
<script>
    var initial = <?php echo $json; ?>;
    // set the dimensions and margins of the graph
    var margin = {
            top: 10,
            right: 30,
            bottom: 40,
            left: 200
        },
        width = 700 - margin.left - margin.right,
        height = 800 - margin.top - margin.bottom;

    // append the svg object to the body of the page
    var svg = d3.select("#my_dataviz")
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");
    let mouseOver = function(d) {
        window.onmousemove = function(j) {
            x = j.pageX;
            y = j.pageY;
            document.getElementById('state-name').style.top = y - 60 + 'px'
            document.getElementById('state-name').style.left = x + 10 + 'px'
        }
        document.getElementById("state-name").style.opacity = 1
        document.getElementById("state-name").children[0].innerHTML = `${this.getAttribute("data-nom-wilaya")}`
        document.getElementById("state-name").children[1].innerHTML = `Nombre de cas: ${this.getAttribute("data-nbr-cas")}`
    }
    let mouseLeave = function(d) {
        document.getElementById("state-name").style.opacity = 0
    }
    var wilayas = ["Adrar", "Chlef", "Laghouat", "Oum_El_Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanghasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi_Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi_Bel_Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "MSila", "Mascara", "Ouargla", "Oran", "El_Bayadh", "Illizi", "Bordj_Bou_Arréridj", "Boumerdès", "El_Tarf", "Tindouf", "Tissemsilt", "El_Oued", "Khenchela", "Souk_Ahras", "Tipaza", "Mila", "Aïn_Defla", "Naâma", "Aïn_Témouchent", "Ghardaïa", "Relizane"];
    var data = [];
    for (var i = 0; i < 48; i++) {
        data[i] = {
            Country: wilayas[i],
            value: 0
        }
    }
    for (var i = 0; i < wilayas.length; i++) {
        for (var j = 0; j < initial.length; j++) {
            if (wilayas[i] === initial[j].wilaya) {
                data[i].value = parseInt(initial[j].number);
            }
        }
    }
    // console.log(data[0]["value"])
    // Parse the Data


    // Add X axis
    data.sort(function(b, a) {
        return a.value - b.value;
    });

    // Add X axis
    var x = d3.scaleLinear()
        .domain([0, d3.max(data, function(d) {
            return d.value;
        })])
        .range([0, width]);
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end");

    var y = d3.scaleBand()
        .range([0, height])
        .domain(data.map(function(d) {
            return d.Country;
        }))
        .padding(1);
    svg.append("g")
        .call(d3.axisLeft(y))
        .selectAll("text")
        .style("font-size", "12px");


    // Lines
    svg.selectAll("myline")
        .data(data)
        .enter()
        .append("line")
        .attr("x1", function(d) {
            return x(d.value);
        })
        .attr("x2", x(0))
        .attr("y1", function(d) {
            return y(d.Country);
        })
        .attr("y2", function(d) {
            return y(d.Country);
        })
        .attr("stroke", "grey")

    // Circles
    svg.selectAll("mycircle")
        .data(data)
        .enter()
        .append("circle")
        .attr("cx", function(d) {
            return x(d.value);
        })
        .attr("data-nbr-cas", function(d) {
            return d.value
        })
        .attr("data-nom-wilaya", function(d) {
            return d.Country
        })
        .attr("cy", function(d) {
            return y(d.Country);
        })
        .attr("r", "5")
        .style("fill", "#69b3a2")
        .attr("stroke", "black")

    d3.selectAll("circle")
        .on("mouseover", mouseOver)
        .on("mouseleave", mouseLeave)
</script>

</html>