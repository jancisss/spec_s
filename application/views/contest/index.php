<div id ="contest">
    <!DOCTYPE html>
    <meta charset="utf-8">
    <style>

      


    </style>
    <h2>Ministijas padoto institūciju iepirkumi</h2>
    <ul>
        <?php
        
        foreach ($ministerieal as $ministry) {
            ?><li><a  href="<?php echo base_url("contest/inst_iub/$ministry->id"); ?>"><?php echo $ministry->nosaukums; ?></a></li> <?php
    }
        ?>
    </ul>
    <h1>Ministriju iepirkumi</h1>

    <table >
        <tr>
            <td id="link_1" >Ekonomikas ministrija</td>
            <td id="link_1b" ></td>
        </tr>
        <tr>
            <td id="link_2">Finanšu ministrija</td>
            <td width ="60px" id="link_2b"></td>
        </tr>
        <tr>
            <td id="link_3">Izglītības un zinātnes ministrija</td>
            <td width ="60px" id="link_3b"></td>
        </tr>
        <tr>
            <td id="link_4">Vesalības ministrija</td>
            <td width ="60px" id="link_4b"></td>
        </tr>
    </table>
    <script>
         
        var diameter = 960,
        format = d3.format(",d"),
        color = d3.scale.category10();
        

        var bubble = d3.layout.pack()
        .sort(null)
        .size([diameter, diameter])
        .padding(1.5);
        

        var svg = d3.select("#contest").append("svg")
        .attr("width", diameter)
        .attr("height", diameter)
        .attr("class", "bubble");

        d3.json("<?php echo base_url('/ministry_data.json'); ?>", function(error, root) {
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