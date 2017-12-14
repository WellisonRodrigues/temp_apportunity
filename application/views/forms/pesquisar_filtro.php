<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/11/2017
 * Time: 00:01
 */
?>
<div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
    <div class="row">
        <?php echo form_open('Pesquisar/listar', array('id' => 'formulario', 'method' => 'post', 'role' => 'form'));
        ?>
        <div class="col-lg-6">
            <div class="form-group">
                <select class="form-control" id="type" name="type">
                    <option id="companies" value="companies">Empresa</option>
                    <!--<option id="users" value="users">Estabelecimento</option>-->
                    <option id="users" value="users">Pessoa Fisica</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <input type="text" class="form-control" id="regiao" name="regiao"
                       placeholder="Região (São Paulo, Belo Horizonte , Rio de Janeiro)">
                <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                  </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <?php echo form_close() ?>
    </div><!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-body">
                <?php print_r($response); ?>
                <?php foreach ($response as $item){?>
                <div class="col-md-3">
                    <div class="jumbotron">
                        <div class="text-center">
                            <img src="<?php echo base_url(IMAGES); ?>/profile.jpg"
                                 class="img-circle"
                                 width="50%"
                                 height="50%"><br>
                            <b> <?php echo $follow['attributes']['name'] ?><br>
                                <?php echo $follow['attributes']['age'] ?> Anos</b><br>
                            <button type="button" onclick="<?php echo $status ?>(<?php echo $follow['id'] ?>)"
                                    class="<?php echo $class ?> <?php echo $status ?>">
                                <?php echo $status ?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    /*
    $(function () {
        $("form#formulario").submit(function (e) {
            var type = $("#type").val();
            var regiao = $("#regiao").val();
            $.post('<?php echo base_url()?>Pesquisar/listar', {regiao: regiao, type: type}, function (data) {
            });
            return false;
        })
    })*/
</script>
<!--</div>-->