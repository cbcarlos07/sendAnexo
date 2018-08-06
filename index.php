<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <br>
    <div class="col-lg-12" >
        <div class="row">
            <form id="idForm" onsubmit="return false" method="post" action="#" >
                <input type="hidden" name="acao" id="acao" value="I">
                <div class="col-lg-4 form-group" >

                    <input type="hidden" name="codigo" id="codigo" value="0">
                    <input name="nome" id="nome">
                </div>
                <div class="col-lg-4  form-group">
                    <input type="file" name="arquivo" id="arquivo" >

                </div>
                <div class="col-lg-4">
                    <button class="btn btn-success btn-xs btn-salvar">Salvar</button>
                    <button class="btn btn-warning btn-xs btn_cancelar" style="display: none">Cancelar</button>
                </div>

            </form>
        </div>
        <div class="table">
            <table class="table table-responsive table-bordered">
                <thead>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>URl</th>
                    <th>Acao</th>
                </thead>
                <tbody>
                    <?php
                      include_once 'class.dbDao.php';
                      $dao = new dbDao();
                      $lista = $dao->listar();
                      foreach ($lista as $dados => $value){
                        ?>
                       <tr>
                           <td><?php echo $value['codigo'];   ?></td>
                           <td><?php echo $value['nome'];   ?></td>
                           <td>
                               <a href="#alterar" class="btn btn-warning btn-alterar">Alterar</a>
                               <?php
                                   if( $value['url'] != null ){
                                       if(file_exists( 'arquivo/'.$value['url'] )){
                                           echo "<a href='#remover' class='btn btn-danger btn-remover' data-url='".$value['url']."'>Remover ".$value['url']."</a>";
                                       }
                                   }
                               ?>
                           </td>
                           <td><?php echo file_exists( 'arquivo/'.$value['url'] ) ? '<a href="#click" data-url="'.$value['url'].'" class="btn_baixar">Baixar</a>' : '';   ?></td>
                       </tr>
                    <?php

                      }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>