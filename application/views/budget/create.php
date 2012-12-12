<div class="span11 center_elem  main_elem">
	<h2>Budžets</h2>
	<ul><?php foreach ($programs as $program): ?>
		<li><?php echo $program->name;?>
			<ul><?php foreach ($program->children as $subprogram): ?>
				<li><?php echo $subprogram->name;?></li>
			<?php endforeach;?></ul>
		</li>
	<?php endforeach; ?></ul>
	
	<!--<pre><?php //print_r($programs);?></pre>-->
</div>