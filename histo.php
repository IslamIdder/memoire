<!DOCTYPE html>
<meta charset="utf-8">

<!-- Load d3.js -->
<script src="https://d3js.org/d3.v4.js"></script>

<!-- Create a div where the graph will take place -->
<div class="chart" id="histo"></div>
<script>
    function createHistoChart(data) {
        // set the dimensions and margins of the graph
        var margin = {
                top: 10,
                right: 30,
                bottom: 30,
                left: 40
            },
            width = 800 - margin.left - margin.right,
            height = 500 - margin.top - margin.bottom;

        // append the svg object to the body of the page
        var svg = d3
            .select("#histo")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        // get the data

        var keys = Object.keys(data);

        // X axis: scale and draw
        var x = d3
            .scaleBand()
            .domain(keys)
            .range([0, width])
            .padding(0.1);
        svg
            .append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x))
            .selectAll("text")
            .style("font-size", "11px"); // Set the desired font size

        // Y axis: scale and draw
        var y = d3.scaleLinear().range([height, 0]);
        y.domain([0, d3.max(Object.values(data))]);
        svg.append("g").call(d3.axisLeft(y));

        // append the bar rectangles to the svg element
        svg
            .selectAll("rect")
            .data(Object.entries(data))
            .enter()
            .append("rect")
            .attr("x", function(d) {
                return x(d[0]);
            })
            .attr("width", x.bandwidth())
            .attr("y", function(d) {
                return y(d[1]);
            })
            .attr("height", function(d) {
                return height - y(d[1]);
            })
            .style("fill", "var(--color-main)");


    }


    var data = {
        "neurologique": 0,
        "endocrinien": 0,
        "rachis": 0,
        "peau": 0,
        "ophalmique": 0,
        "orl": 0,
        "respiratoire": 0,
        "cardio": 0,
        "digestif": 0,
        "urinaire": 0,
        "genital": 0
    };
    createHistoChart(data)
</script>
<!-- // var keys = Object.keys(data);
// // set the dimensions and margins of the graph
// var margin = {
// top: 10,
// right: 30,
// bottom: 30,
// left: 40
// },
// width = 800 - margin.left - margin.right,
// height = 500 - margin.top - margin.bottom;

// // append the svg object to the body of the page
// var svg = d3.select("#histo")
// .append("svg")
// .attr("width", width + margin.left + margin.right)
// .attr("height", height + margin.top + margin.bottom)
// .append("g")
// .attr("transform",
// "translate(" + margin.left + "," + margin.top + ")");

// // X axis: scale and draw:
// var x = d3.scaleBand()
// .domain([keys]) // Adjust the domain based on your data
// .range([0, width])
// .padding(0.1);

// svg.append("g")
// .attr("transform", "translate(0," + height + ")")
// .call(d3.axisBottom(x));

// // Y axis: scale and draw:
// var y = d3.scaleLinear()
// .range([height, 0])
// .domain([0, d3.max(Object.values(data))]);

// svg.append("g")
// .call(d3.axisLeft(y));

// // Append the bar rectangles to the svg element
// svg.selectAll("rect")
// .data(Object.entries(data))
// .enter()
// .append("rect")
// .attr("x", function(d) {
// return xScale(d);
// })
// .attr("width", x(1) - x(0) - 1)
// .attr("height", function(d) {
// return height - y(d[1]);
// })
// .style("fill", "#69b3a2"); -->
<!-- // set the dimensions and margins of the graph

    var data = {
        "neurologique":0,
        "endocrinien":0,
        "rachis":0,
        "peau":0,
        "ophalmique":0,
        "orl":0,
        "respiratoire":0,
        "cardio":0,
        "digestif":0,
        "urinaire":0,
        "genital":0
    };

    var keys = Object.keys(data);

    var margin = {
        top: 20,
        right: 20,
        bottom: 40,
        left: 40
    };
    var width = 800 - margin.left - margin.right;
    var height = 500 - margin.top - margin.bottom;

    var xScale = d3.scaleBand()
        .domain(keys)
        .range([0, width])
        .padding(0.1);

    var yScale = d3.scaleLinear()
        .domain([0, 100])
        .range([height, 0]);

    var svg = d3.select("#histo")
        .append("svg")
        .attr("class", "charts")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    svg.selectAll(".bar")
        .data(keys)
        .enter()
        .append("rect")
        .attr("fill", "var(--color-main)")
        .attr("class", "bar")
        .attr("x", function(d) {
            return xScale(d);
        })
        .attr("y", function(d) {
            return yScale(data[d]);
        })
        .attr("width", xScale.bandwidth())
        .attr("height", function(d) {
            return height - yScale(data[d]);
        });

    svg.append("g")
        .attr("class", "axis-x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(xScale)); -->