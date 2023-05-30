<div id="lolipop" class="chart" style="display:none;"></div>
<script>
    function createLolipopChart(data) {
        var margin = {
                top: 10,
                right: 30,
                bottom: 40,
                left: 200
            },
            width = 700 - margin.left - margin.right,
            height = 800 - margin.top - margin.bottom;
        var svg = d3.select("#lolipop")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");
        let lolipop_mouseOver = function(d) {
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
        let lolipop_mouseLeave = function(d) {
            document.getElementById("state-name").style.opacity = 0
        }

        data.sort(function(b, a) {
            return a.value - b.value;
        });
        var x = d3.scaleLinear()
            .domain([0, d3.max(data, function(d) {
                if (d.value === 0)
                    return 1
                else
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
                return d.wilaya;
            }))
            .padding(1);
        svg.append("g")
            .call(d3.axisLeft(y))
            .selectAll("text")
            .style("font-size", "12px");
        svg.selectAll("myline")
            .data(data)
            .enter()
            .append("line")
            .attr("x1", function(d) {
                return x(d.value);
            })
            .attr("x2", x(0))
            .attr("y1", function(d) {
                return y(d.wilaya);
            })
            .attr("y2", function(d) {
                return y(d.wilaya);
            })
            .attr("stroke", "grey")
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
                return d.wilaya
            })
            .attr("cy", function(d) {
                return y(d.wilaya);
            })
            .attr("r", "5")
            .style("fill", "#5c91e5")
            .attr("stroke", "black")

        d3.selectAll("circle")
            .on("mouseover", lolipop_mouseOver)
            .on("mouseleave", lolipop_mouseLeave)
    }

    var wilayas = ["Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "MSila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane"];
    var data = [];
    for (var i = 0; i < 48; i++) {
        data[i] = {
            wilaya: wilayas[i],
            value: 0
        }
    }
    createLolipopChart(data);
</script>

</html>