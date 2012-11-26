<div id ="contest">
    <!DOCTYPE html>
    <meta charset="utf-8">
    <style>

        text {
            font: 10px sans-serif;
        }
        #izglitibas_zin_ministrija{
            color:#3399cc;
            font-weight:bold;
        }
        #ekanomikas_ministrija{
            color:#2CA02C;
            font-weight:bold;
        }
        #vesalibas_ministrija{
            color:#D62728;
            font-weight:bold;
        }

    </style>
    <!--<script src="http://d3js.org/d3.v3.min.js"></script> -->
    <script src="<?php echo base_url('/scripts/d3.v2.js');?>"></script>
    <h3 id ="izglitibas_zin_ministrija">Izglītības un zinātnes ministrija</h3>
    <h3 id ="ekanomikas_ministrija">Ekanomikas ministrija</h3>
    <h3 id ="vesalibas_ministrija">Vesalības ministrija</h3>
    <script>
         
        var diameter = 960,
        format = d3.format(",d"),
        color = d3.scale.category10();
        //alert(getRoot2(4));
        //alert(Math.SQRT2(4));
        //alert(Math.sqrt(4));

        var bubble = d3.layout.pack()
        .sort(null)
        .size([diameter, diameter])
        .padding(1.5);
        

        var svg = d3.select("#contest").append("svg")
        .attr("width", diameter)
        .attr("height", diameter)
        .attr("class", "bubble");

        d3.json("testFile.json", function(error, root) {
            var node = svg.selectAll(".node")
            .data(bubble.nodes(classes(root))
            .filter(function(d) { return !d.children; }))
            .enter().append("g")
            .attr("class", "node")
            .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
console.log(bubble.nodes(classes(root)));
            node.append("title")
            .text(function(d) { return d.className + ": " + format(d.value); });

            node.append("circle")
            .attr("r", function(d) { return d.r })
            .style("fill", function(d) { return color(d.packageName); });

            node.append("text")
            .attr("dy", ".3em")
            .style("text-anchor", "middle")
            .text(function(d) { return d.className.substring(0, d.r / 3); });
        });

        // Returns a flattened hierarchy containing all leaf nodes under the root.
        function classes(root) {
            var classes = [];

            function recurse(name, node) {
                if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
                else classes.push({packageName: name, className: node.name, value: node.size});
            }

            recurse(null, root);
            return {children: classes};
        }

        d3.select(self.frameElement).style("height", diameter + "px");

    </script>

</div>