<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/11/2017
 * Time: 16:58
 */
//print_r($follows['response']['included']);
foreach ($follows['response']['included'] as $follow) {
//    print_r($follow['profiles']);
//
//
    ?>
    <div class="col-md-4">
        <div class="jumbotron">
            <div class="text-center">
                <img src="<?php echo base_url(IMAGES); ?>/profile.jpg"
                     class="img-circle"
                     width="50%"
                     height="50%"><br>
                <b> <?php echo $follow['attributes']['name'] ?><br>
                    <?php echo $follow['attributes']['age'] ?> Anos</b><br>
                <button type="button" class="btn btn-primary segue">
                    Seguindo
                </button>

            </div>
        </div>
    </div>

<?php } ?>