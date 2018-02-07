<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 06/02/2018
 * Time: 21:58
 */

?>
<div class="media msg message" id="<?php echo $idmessage ?>">
    <a class="pull-left" href="#">
        <img class="media-object" data-src="holder.js/64x64" alt="64x64"
             style="width: 32px; height: 32px;"
             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQjUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyckJms0m9vf3EY/H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fHzGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq//szG5eWlGA1ywOnpqQhBapoWPfl+vw+fzweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05GnR99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B20590n7IDflIzMmdhAfiNEL8R4jdC/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH3FfAAAAAElFTkSuQmCC">
    </a>
    <a class="pull-right" href="#">
        <i class="fa fa-trash delete<?php echo $idmessage ?>"></i>
    </a>
    <div class="media-body">
        <!--                    <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>-->
        <h5 class="media-heading"> <?php echo $id ?></h5>
        <small class="col-lg-10">
            <?php echo $text ?>
        </small>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.delete' + '<?php echo $idmessage?>').bind('click', function () {
            if (confirm('deseja excluir?') == true) {
                $.get('Mensagens/delete_message/<?php echo $idmessage?>', function (data) {
                    $("#<?php echo $idmessage?> ").remove();
                })
            }
        });
    });
</script>