<div id ="contest" class="span11 center_elem  main_elem">
   <?php if ($data==FALSE ) {
       ?><h3><?php echo $ministry_title[0]->nosaukums;?> nav publisko iuebpikumi 2011. gadā</h3><?php
   } else{?>
    <h3><?php echo $ministry_title[0]->nosaukums;?> padoto institūciju dati</h3>
    
   <table >
   <?php 
  //print_r($ministry_title);
   $skaititajs = 1;
   foreach($inst_list as $list){
         ?>
        <tr>
            <td ><a id="link_<?php echo $skaititajs; ?>"  href="<?php echo base_url("Inst/inst/$list->id"); ?>"><?php echo $list->nosaukums?></a></td>
            <td id="link_<?php echo $skaititajs; ?>b"  width="50" ></td>
        </tr>
       
   
    <?php
    $skaititajs++;
   }
       
   ?>
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

        d3.json("<?php echo base_url('sub_inst.json');?>", function(error, root) {
            var node = svg.selectAll(".node")
            .data(bubble.nodes(classes(root))
            .filter(function(d) { return !d.children; }))
            .enter().append("g")
            .attr("class", "node")
            .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
console.log(bubble.nodes(classes(root)));
            node.append("title")
            .text(function(d) { return d.className + ": " + format(d.value*d.value); });

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
<?php } ?>
</div>