<?php
//print_r($comentarios);
foreach ($comentarios as $comentario) {
    ?>
    <div class="social-comment">
        <a href="" class="pull-left">
            <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">
        </a>
        <div class="media-body">
            <a href="#">
                Andrew Williams
            </a>
            <?php
            echo $comentario["attributes"]["message"];
            ?>
            <br>
            <a href="#" class="small"><i class="fa fa-thumbs-up"></i> 26 Like this!</a> -
            <small class="text-muted">  <?php echo date('d/m/Y H:i:s', strtotime($job['attributes']['created-at-at'])) ?></small>
        </div>
    </div>

    <?php
}
?>