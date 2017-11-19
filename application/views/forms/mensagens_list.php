<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
    <h1>Mensagens</h1>

    <hr>

    <div class="clearfix"></div>

    <script>
        $(document).ready(function () {
            $('.remover').bind('click', function () {
                //$(".fa-heart-o").css("color", "red");
                var idanuncio = $(this).attr('href');
                $('tr#'+idanuncio).remove();
                $.post('Anuncios/deletar', {idanuncio: idanuncio}, function (data) {
                }, 'json');
                return false;
            });
            $(".editar2").bind('click',function(){
                var id = $(this).data('codigo');
                $.post('Anuncios/deletar', {idanuncio: idanuncio}, function (data) {

                }, 'json');
                return false;
                $('#myModal').show();
            })
        });
    </script>
</div>
