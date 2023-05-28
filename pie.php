<!DOCTYPE html>
<meta charset="utf-8">

<script src="https://d3js.org/d3.v4.js"></script>

<div class="chart" id="pie"></div>

<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
<script>
    function createPieChart(data) {
        var width = 700
        height = 700
        margin = 40

        var radius = Math.min(width, height) / 2 - margin
        var svg = d3.select("#pie")
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");


        var color = d3.scaleOrdinal()
            .domain(data)
            .range(d3.schemeBlues[7]);

        var pie = d3.pie()
            .value(function(d) {
                return d.value;
            })
        var data_ready = pie(d3.entries(data))
        var arcGenerator = d3.arc()
            .innerRadius(0)
            .outerRadius(radius)

        svg
            .selectAll('mySlices')
            .data(data_ready)
            .enter()
            .append('path')
            .attr('d', arcGenerator)
            .attr('fill', function(d) {
                return (color(d.data.key))
            })
            .attr("stroke", "black")
            .style("stroke-width", "1px")
            .style("opacity", 0.7)

        var formatPercent = d3.format('.1%');
        svg
            .selectAll('mySlices')
            .data(data_ready)
            .enter()
            .append('text')
            .text(function(d) {
                return d.data.key;
            })
            .attr("transform", function(d) {
                return "translate(" + arcGenerator.centroid(d) + ")";
            })
            .style("text-anchor", "middle")
            .style("font-size", 12)
    }

    var data = {
        "neurologique": 100 / 11,
        "endocrinien": 100 / 11,
        "rachis": 100 / 11,
        "peau": 100 / 11,
        "ophalmique": 100 / 11,
        "orl": 100 / 11,
        "respiratoire": 100 / 11,
        "cardio": 100 / 11,
        "digestif": 100 / 11,
        "urinaire": 100 / 11,
        "genital": 100 / 11
    };
    createPieChart(data);
</script>