<div id ="contest">


    <h2>Institūcijas</h2>
    <?php
    /* foreach($institutions as $institution){
      echo "<div>". $institution->nosaukums . '</div>';
      }
      ?>
      <h2>Oranizācijas</h2>
      <?php
      foreach($organizations as $organization){
      echo "<div>". $organization->title . '</div>';
      } */
    ?>


    <!DOCTYPE html>
    <meta charset="utf-8">
    <style>

        .node {
            stroke: #fff;
            stroke-width: 1.5px;
        }

        .link {
            stroke: #999;
            stroke-opacity: .6;
        }

    </style>
    <body>
        <?php
        $node1 = array("name" => "Myriel", "group" => 1);
        $node2 = array("name" => "Myriel2", "group" => 2);
        $node3 = array("name" => "Myriel23", "group" => 1);
        $nodes = array($node1, $node2, $node3);

        $link1 = array("source" => 1, "target" => 0, "value" => 0);
        $link2 = array("source" => 1, "target" => 2, "value" => 0);
        $link3 = array("source" => 1, "target" => 2, "value" => 0);
        $links = array($link1, $link2, $link3);

        $arr = array('nodes' => $nodes, 'links' => $links);

        $myFile = "janis.json";
        $fh = fopen($myFile, 'w') or die("can't open file");


        fwrite($fh, json_encode($arr));
        fclose($fh);
        ?>
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script>
            
            var dataset = [ 5, 10, 13, 19, 21, 25, 22, 18, 15, 13,
                11, 12, 15, 20, 18, 17, 16, 18, 23, 25 ];

            d3.select("#contest")
            .data(dataset)
            .enter()
            .append("div")
            .attr("class", "bar")
            .style("height", function(d) {
                var barHeight = d * 5;
                return barHeight + "px";
                alert('janis');
            });

            var width = 950,
            height = 500;

            var color = d3.scale.category20();

            var force = d3.layout.force()
            .charge(-120)
            .linkDistance(30)
            .size([width, height]);

            var svg = d3.select('#contest').append("svg")
            .attr("width", width)
            .attr("height", height);

            d3.json('janis.json', function(error, graph) {
                force
                .nodes(graph.nodes)
                .links(graph.links)
                .start();

                var link = svg.selectAll("line.link")
                .data(graph.links)
                .enter().append("line")
                .attr("class", "link")
                .style("stroke-width", function(d) { return Math.sqrt(d.value); });

                var node = svg.selectAll("circle.node")
                .data(graph.nodes)
                .enter().append("text")
                .text("janis")
                .attr("class", "node")
                .attr("r", 10)
                .style("fill", function(d) { return color(d.group); })
                .call(force.drag);           
                

                node.append("title")
                .text(function(d) { return d.name; });
               
              
                force.on("tick", function() {
                    link.attr("x1", function(d) { return d.source.x; })
                    .attr("y1", function(d) { return d.source.y; })
                    .attr("x2", function(d) { return d.target.x; })
                    .attr("y2", function(d) { return d.target.y; });

                    node.attr("cx", function(d) { return d.x; })
                    .attr("cy", function(d) { return d.y; });
                });
                
            });
            
        

        </script>





        <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Force based label placement</title>
            <script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?2.6.0"></script>
            <script type="text/javascript" src="http://mbostock.github.com/d3/d3.layout.js?2.6.0"></script>
            <script type="text/javascript" src="http://mbostock.github.com/d3/d3.geom.js?2.6.0"></script>
        </head>
        <body>
            <script type="text/javascript" charset="utf-8">
                var w = 960, h = 500;

                var labelDistance = 0;

                var vis = d3.select("body").append("svg:svg").attr("width", w).attr("height", h);

                var nodes = [];
                var labelAnchors = [];
                var labelAnchorLinks = [];
                var links = [];

                for(var i = 0; i < 30; i++) {
                    var node = {
                        label : "Institūcija " + i
                    };
                    nodes.push(node);
                    labelAnchors.push({
                        node : node
                    });
                    labelAnchors.push({
                        node : node
                    });
                };

                for(var i = 0; i < nodes.length; i++) {
                    for(var j = 0; j < i; j++) {
                        if(Math.random() > .95)
                            links.push({
                                source : i,
                                target : j,
                                weight : Math.random()
                            });
                    }
                    labelAnchorLinks.push({
                        source : i * 2,
                        target : i * 2 + 1,
                        weight : 1
                    });
                };

                var force = d3.layout.force().size([w, h]).nodes(nodes).links(links).gravity(1).linkDistance(50).charge(-3000).linkStrength(function(x) {
                    return x.weight * 10
                });


                force.start();

                var force2 = d3.layout.force().nodes(labelAnchors).links(labelAnchorLinks).gravity(0).linkDistance(0).linkStrength(8).charge(-100).size([w, h]);
                force2.start();

                var link = vis.selectAll("line.link").data(links).enter().append("svg:line").attr("class", "link").style("stroke", "#CCC");

                var node = vis.selectAll("g.node").data(force.nodes()).enter().append("svg:g").attr("class", "node");
                node.append("svg:circle").attr("r", 5).style("fill", "#555").style("stroke", "#FFF").style("stroke-width", 3);
                node.call(force.drag);


                var anchorLink = vis.selectAll("line.anchorLink").data(labelAnchorLinks)//.enter().append("svg:line").attr("class", "anchorLink").style("stroke", "#999");

                var anchorNode = vis.selectAll("g.anchorNode").data(force2.nodes()).enter().append("svg:g").attr("class", "anchorNode");
                anchorNode.append("svg:circle").attr("r", 0).style("fill", "#FFF");
                anchorNode.append("svg:text").text(function(d, i) {
                    return i % 2 == 0 ? "" : d.node.label
                }).style("fill", "#555").style("font-family", "Arial").style("font-size", 12);

                var updateLink = function() {
                    this.attr("x1", function(d) {
                        return d.source.x;
                    }).attr("y1", function(d) {
                        return d.source.y;
                    }).attr("x2", function(d) {
                        return d.target.x;
                    }).attr("y2", function(d) {
                        return d.target.y;
                    });

                }

                var updateNode = function() {
                    this.attr("transform", function(d) {
                        return "translate(" + d.x + "," + d.y + ")";
                    });

                }


                force.on("tick", function() {

                    force2.start();

                    node.call(updateNode);

                    anchorNode.each(function(d, i) {
                        if(i % 2 == 0) {
                            d.x = d.node.x;
                            d.y = d.node.y;
                        } else {
                            var b = this.childNodes[1].getBBox();

                            var diffX = d.x - d.node.x;
                            var diffY = d.y - d.node.y;

                            var dist = Math.sqrt(diffX * diffX + diffY * diffY);

                            var shiftX = b.width * (diffX - dist) / (dist * 2);
                            shiftX = Math.max(-b.width, Math.min(0, shiftX));
                            var shiftY = 5;
                            this.childNodes[1].setAttribute("transform", "translate(" + shiftX + "," + shiftY + ")");
                        }
                    });


                    anchorNode.call(updateNode);

                    link.call(updateLink);
                    anchorLink.call(updateLink);

                });

            </script>
        </body>
    </html>

</div>