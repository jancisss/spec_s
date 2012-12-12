<div id="content" class="span11 center_elem  main_elem">
    <?php
    ?> <h1> <?php echo $inst_s[0]->nosaukums; ?> </h1>


    <table >
        <tr>
            <td>Juridiskais statuss</td>
            <td><?php echo $inst_s[0]->juridiskais_ststuss ?></td>
        </tr>
        <?php if (isset($inst_s[0]->padotibas_forma)) { ?>
            <tr>
                <td>Padotibas forma</td>
                <td><?php echo $inst_s[0]->padotibas_forma ?></td>
            </tr>
        <?php } ?>
        <?php if (isset($inst_s[0]->padotibas_ministrija)) { ?>
            <tr>
                <td>Padotības ministrija/td>
                <td><?php echo $inst_s[0]->padotibas_ministrija ?></td>
            </tr>
        <?php } ?>
            <?php if (isset($inst_s[0]->adrese)) { ?>
        <tr>
            <td>Adrese</td>
            <td><?php echo $inst_s[0]->adrese ?></td>
        </tr>
        <?php } ?>
            <?php if (isset($inst_s[0]->telefons)) { ?>
        <tr>
            <td>Telefons</td>
            <td><?php echo $inst_s[0]->telefons ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->majas_lapa)) { ?>
        <tr>
            <td>Mājas lapa</td>
            <td><?php echo $inst_s[0]->majas_lapa ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->e_pasts)) { ?>
        <tr>
            <td>E-pasts</td>
            <td><?php echo $inst_s[0]->e_pasts ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->darba_laiks)) { ?>
        <tr>
            <td>Darba laiks</td>
            <td><?php echo $inst_s[0]->darba_laiks ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->pienemsanas_laiki)) { ?>
        <tr>
            <td>Pieņemšanas laiki</td>
            <td><?php echo $inst_s[0]->pienemsanas_laiki ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->noteikumi)) { ?>
        <tr>
            <td>Noteikumi</td>
            <td><?php echo $inst_s[0]->noteikumi ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->reglaments)) { ?>
        <tr>
            <td>Reglaments</td>
            <td><?php echo $inst_s[0]->reglaments ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->struktura)) { ?>
        <tr>
            <td>Struktūra</td>
            <td><?php echo $inst_s[0]->struktura ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->normativo_aktu_saraksts)) { ?>
        <tr>
            <td>Normatīvo aktu saraksts</td>
            <td><?php echo $inst_s[0]->normativo_aktu_saraksts ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->publisks_parskats)) { ?>
        <tr>
            <td>Publiskais pārskats</td>
            <td><?php echo $inst_s[0]->publisks_parskats ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->mk_rikojums)) { ?>
        <tr>
            <td>Ministru kabineta rīkojums</td>
            <td><?php echo $inst_s[0]->mk_rikojums ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->strategija)) { ?>
        <tr>
            <td>Stratēģija</td>
            <td><?php echo $inst_s[0]->strategija ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->merki_rezultati)) { ?>
        <tr>
            <td>Mērķi rezultati</td>
            <td><?php echo $inst_s[0]->merki_rezultati ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->budzets)) { ?>
        <tr>
            <td>Budžets</td>
            <td><?php echo $inst_s[0]->budzets ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->papildus_skaidrojums)) { ?>
        <tr>
            <td>Papildus skaidrojums</td>
            <td><?php echo $inst_s[0]->papildus_skaidrojums ?></td>
        </tr>
         <?php } ?>
            <?php if (isset($inst_s[0]->amatpersonas)) { ?>
        <tr>
            
            <td>Amatpersonas</td>
            <td><?php echo $inst_s[0]->amatpersonas ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php if ($yes_iub == TRUE) { ?>
        <h2><?php echo $inst_s[0]->nosaukums . ' publiskie iepikumi';
        ?></h2>
        <div id="char"></div>
        <script>
            
             
            var diameter = 960,
            format = d3.format(",d"),
            color = d3.scale.category10();
            

            var bubble = d3.layout.pack()
            .sort(null)
            .size([diameter, diameter])
            .padding(1.5);
            

            var svg = d3.select("#char").append("svg")
            .attr("width", diameter)
            .attr("height", diameter)
            .attr("class", "bubble");

            d3.json("<?php echo base_url('/inst_json.json'); ?>", function(error, root) {
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