<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/01/2018
 * Time: 15:04
 */
//print_r($chanel_name);
//echo '<br/>';
//print_r($idchat);
?>
<!--<script src="https://js.pusher.com/4.1/pusher.min.js"></script>-->
<div class="message-wrap col-lg-8">
    <div class="msg-wrap">

        <?php foreach ($return['data'] as $retorno) {
//            print_r($retorno);
            ?>

            <div class="media msg message">
                <a class="pull-left" href="#">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64"
                         style="width: 32px; height: 32px;"
                         src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQjUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyckJms0m9vf3EY/H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fHzGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq//szG5eWlGA1ywOnpqQhBapoWPfl+vw+fzweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05GnR99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B20590n7IDflIzMmdhAfiNEL8R4jdC/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH3FfAAAAAElFTkSuQmCC">
                </a>
                <div class="media-body">
                    <!--                    <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>-->
                    <h5 class="media-heading"> <?php echo $retorno['relationships']['sender']['data']['id'] ?></h5>
                    <small class="col-lg-10">
                        <?php echo $retorno['attributes']['text'] ?>
                    </small>
                </div>
            </div>
            <!--            <div class="alert alert-info msg-date">-->
            <!--                <strong>Today</strong>-->
            <!--            </div>-->
        <?php } ?>

    </div>

    <div class="send-wrap ">

        <textarea class="form-control send-message" rows="3" placeholder="Write a reply..."></textarea>


    </div>
    <div class="btn-panel">
        <!--                <a href="" class=" col-lg-3 btn btn-primary  send-message-btn " role="button"><i class="fa fa-cloud-upload">-->
        <!--                    </i> Add Files</a>-->
        <a href="" class=" col-lg-4 text-right btn  btn-primary send-message-btn pull-right" role="button">
            <i class="fa fa-plus"></i> Enviar</a>
    </div>
</div>
<script>
    $(document).ready(function () {

        Pusher.logToConsole = true;

        var pusher = new Pusher('18ce9b3cf233d1eb0916', {
            cluster: 'us2',
            encrypted: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            $(".msg-wrap").append('<div class="media msg message"><a class="pull-left" href="#">' +
                '<img class="media-object" data-src="holder.js/64x64" alt="64x64"style="width: 32px; height: 32px;"' +
                'src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQ' +
                'jUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY' +
                '5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyck' +
                'Jms0m9vf3EY/H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1' +
                'I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fH' +
                'zGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq//szG5eWlGA1ywOnpqQhBapoWPfl+vw+f' +
                'zweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05Gn' +
                'R99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B205' +
                '90n7IDflIzMmdhAfiNEL8R4jdC/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH' +
                '3FfAAAAAElFTkSuQmCC"> </a><div class="media-body"> <small class="pull-right time"><' +
                'i class="fa fa-clock-o"></i> 12:10am</small> <h5 class="media-heading"> <?php echo $retorno['relationships']['sender']['data']['id'] ?></h5><small class="col-lg-10">' + data.message + '</small></div>');
            alert(data.message);
        });
    });
</script>


