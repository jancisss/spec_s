<html>
    <head>
		<meta charset='utf-8' />
        <title>D3</title>
        <script type="text/javascript" src="<?php echo base_url() . 'scripts/d3.v2.js'; ?>"></script>
		<style>
			rect{
				fill: grey;
			}
		</style>
    </head>
    <body>
		<article></article>
		<script type="text/javascript">
			var w = 1000, //svg width
				h = 270, //svg height
				barPadding = 2, //vertikālā atstarpe starp elementiem
				barTopPadding = 2, //horizontālā atstarpe starp elementiem
				reduceBy = 2, //koef. par cik samazinās elements
				barMinHeight = 20, //mazākais elementa augstums
				barHeight = 250, //elementu augstums
				xDomainMax = 0, //xScale domēna maksimālā vērtība
				xScale = d3.scale.linear().range([0, w]);

			var svg = d3.select('article')
						.append('svg')
						.attr("width", w)
						.attr("height", h);
			
			var partition = d3.layout.partition();
			
			d3.json("<?php echo base_url() . 'data/budget.json';?>", function(json) {
				var nodes = partition.nodes(json);
				
				for (var i = 0; i < nodes.length; ++i) {
					if(nodes[i].depth > 0){
						nodes.splice(i, 1);
						--i;
					}else{
						xDomainMax = xDomainMax + nodes[i].value;
					}
				}
				xScale.domain([0, xDomainMax]);
				//console.log(nodes);
				
				svg.selectAll('rect')
					.data(nodes)
				   .enter()
					.append('rect')
					.attr('x', 0)
					.attr('y', 0)
					.attr('width', function(d){return xScale(d.value);})
					.attr('height', barHeight)
					.attr('class', 'rect_0')
					.attr('title', function(d){return d.title;})
					.on('click', function(d){
						draw(d.children)
					});
			});
			
			function draw(node){
				xScale.domain([0, node[0].parent.value]);
				var curDepth = node[0].depth;
				
				var newSvgHeight = barHeight + barTopPadding * 2;
				for (var i = 1; i <= (curDepth); i++){
					var addHeight = barHeight/(Math.pow(reduceBy,i));
					if (addHeight < barMinHeight) addHeight = barMinHeight;
					newSvgHeight = newSvgHeight + barTopPadding + addHeight;
				}
				svg.attr('height', newSvgHeight);
				
				svg.selectAll('rect')
					.transition()
					.attr('height', function(d){
						var newHeight = barHeight/(Math.pow(reduceBy,(curDepth - d.depth)));
						if (newHeight < barMinHeight) newHeight = barMinHeight;
						return newHeight;
					})					
					.attr('y', function(d){
						var yPos = barTopPadding * (curDepth - d.depth);
						for (var i = 0; i < (curDepth - d.depth); i++){
							var add = barHeight/(Math.pow(reduceBy,i));
							if (add < barMinHeight) add = barMinHeight;
							yPos = yPos + add;
						}
						return yPos;
					});
				var nodeLength = node.length;
				var widthReduce = (barPadding * (nodeLength - 1)) / nodeLength;
				var dataSvg = svg.selectAll('.rect_'+node[0].depth)
					.data(node);
					
				dataSvg.transition()
					.attr('x', function(d, i){
						if(node.length == 1)
							return xScale(xDomainMax * (d.x - d.parent.x));
						else
							return xScale(xDomainMax * (d.x - d.parent.x)) + ((barPadding - widthReduce) * (i));
					})
					.attr('width', function(d){
						if(node.length == 1)
							return xScale(d.value);
						else
							return xScale(d.value) - widthReduce;					
					});
				dataSvg.enter()
					.append('rect')
					.attr('y', 0)
					.attr('x', function(d, i){
						if(node.length == 1)
							return xScale(xDomainMax * (d.x - d.parent.x));
						else
							return xScale(xDomainMax * (d.x - d.parent.x)) + ((barPadding - widthReduce) * (i));
					})
					.attr('width', function(d){
						if(node.length == 1)
							return xScale(d.value);
						else
							return xScale(d.value) - widthReduce;
					})
					.attr('class', function(d){return 'rect_' + d.depth;})
					.on('click', function(d){
						draw(d.children);					
					})
					.transition()
						.attr('height', barHeight);
						
				dataSvg.exit()
					.remove();
			}
			
			
        </script>
		
    </body>
</html>