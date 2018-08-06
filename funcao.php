<?php
$opcao = $_POST['acao'];
$nome = "";
$arquivo  = null;
$codigo = 0;
$url = "";
if(isset($_POST['codigo'])){
    $codigo = $_POST['codigo'];
}

if(isset($_POST['url'])){
    $url = $_POST['url'];
}
if( isset($_POST['nome']) ){
    $nome = $_POST['nome'];
}
if( isset( $_FILES['arquivo'] ) ){

    $arquivo = $_FILES['arquivo'];
}


//echo "Opcao: ".$opcao."\n<br>";

switch ($opcao){
    case 'I':
        $value = array(
            'nome'    => $nome,
            'arquivo' => $arquivo
        );
         inserir($value);
        break;
    case 'U':
        $value = array(
            'nome'    => $nome,
            'arquivo' => $arquivo,
            'codigo'  => $codigo
        );
        alterar( $value );
        break;
    case 'R':
        $value = array(
            'id'   => $codigo,
            'url'  => $url
         );
        remover( $value );
        break;
}

function inserir( $value ){
    require_once 'class.dbDao.php';

    $dao = new dbDao();
    $nome = $value['nome'];
    $file = $value['arquivo'];
    $pathParts = pathinfo($file['name']);
    var_dump($file);

    $ext = $pathParts['extension'];
    //echo "ext: ".$ext;
    $name = '_.'.$ext;
    $values = array(
        'nome' => $nome,
        'url'  => $name

    );
    //exit();

    $retorno = $dao->insert($values);

    if( $retorno['status'] ){
        if( $value['arquivo'] != null || $value['arquivo'] != "" ){

            $newLocal = "arquivo/".$retorno['id']."_.".$ext;

            $copy = copy($file["tmp_name"], $newLocal) ;
            var_dump( $copy );
            if( !$copy ) {
                $retorno['copiado'] = 'nao copiado';
            }else{
                $retorno['copiado'] = ' copiado';
            }
        }
    }
    echo json_encode( $retorno );
}

function alterar( $value ){
    require_once 'class.dbDao.php';
    $dao = new dbDao();
    $nome = $value['nome'];
    $file = $value['arquivo'];
    $pathParts = pathinfo($file['name']);
    $ext = pathinfo($pathParts, PATHINFO_EXTENSION);
    $name = '_.'.$ext;
    $values = array(
        'nome' => $nome,
        'url'  => $name,
        'id'  => $value['codigo']
    );

    $retorno = $dao->update($values);

    if( $retorno['status'] ){
        if( $value['arquivo'] != null || $value['arquivo'] == ""){
            $newLocal = "arquivo/".$retorno['id']."_.".$ext;
            if( file_exists( $newLocal ) ){
                unlink( $newLocal );
                copy($file, $newLocal);
            }else{
                copy($file, $newLocal);
            }
        }


    }
    echo json_encode( $retorno );
}

function remover( $value ){
    //var_dump( $value );
    require_once 'class.dbDao.php';
    $dao = new dbDao();
    $retorno = $dao->updateRemoveFile( $value );

    if( $retorno['status'] ){
        $filePath = 'arquivo/'.$value['url'];
        $bool = unlink( $filePath );
        echo "remove: ".$bool;
    }
    echo json_encode( $retorno );

}