<div id="content">
    <ul>
        <?php
        foreach ($inst_s as $inst) {
            ?> <li><a 
                    <?php if ($inst->padotibas_ministrija == NULL) { ?> id="is_ministry" <?php } ?>
                    href="<?php echo base_url("Inst/inst/$inst->id"); ?>"><?php echo $inst->nosaukums; ?></a></li>  <?php
            }
                ?>
    </ul>
</div>