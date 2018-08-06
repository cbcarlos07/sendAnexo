<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 05/08/18
 * Time: 15:57
 */
require_once 'class.connectionFactory.php';
class dbDao
{
  private $connection = null;
  public function insert ($values){
      $this->connection = new ConnectionFactory();
      $query = "INSERT INTO tbtest  (name, url) VALUES (:nome, :url)";
      $this->connection->beginTransaction();
      $retorno = array();
      try{
          $stmt = $this->connection->prepare( $query );
        //  echo "Url: ".$values['url']."\n<br>";
          $stmt->bindValue(":nome", $values['nome'], PDO::PARAM_STR);
          $stmt->bindValue(":url", $values['url'], PDO::PARAM_STR);
          $stmt->execute();
          $lastId = $this->connection->lastInsertId();
          $this->connection->commit();

          $r = $stmt->errorInfo();


          if( $r[2] == null  ){

              $retorno = array(
                  'msg'    => 'Inserido com sucesso!',
                  'id'     => $lastId,
                  'status' => true
              );
              $newPath = $lastId.$values['url'];
              $valor = array(
                  'url'   => $newPath,
                  'id'    => $lastId
              );
              $this->updatePath( $valor );


          }else{
              new PDOException($r[2]);
          }
      }catch (PDOException $exception){
            $retorno = array(
                'msg'    => 'Problema: '.$exception->getMessage(),
                'id'     => 0,
                'status' => false
            );
      }

      return $retorno;

  }

    public function update ($values){
        $this->connection = new ConnectionFactory();
        $query = "UPDATE  tbtest  SET name = :nome , url = :url WHERE codigo = :id";
        $this->connection->beginTransaction();
        $retorno = array();
        try{
            $stmt = $this->connection->prepare( $query );
            $stmt->bindValue(":nome", $values['nome'], PDO::PARAM_STR);
            $stmt->bindValue(":url", $values['url'], PDO::PARAM_STR);
            $stmt->bindValue(":id", $values['id'], PDO::PARAM_INT);
            $stmt->execute();
            $this->connection->commit();
            $r = $stmt->errorInfo();
            if( $r[2] == null  ){
                $retorno = array(
                    'msg'    => 'Alterado com sucesso!',
                    'id'     => $values['id'],
                    'status' => true
                );
            }else{
                new PDOException($r[2]);
            }
        }catch (PDOException $exception){
            $retorno = array(
                'msg'    => 'Problema: '.$exception->getMessage(),
                'id'     => 0,
                'status' => false
            );
        }
        return $retorno;

    }

    public function updateRemoveFile ($values){
        $this->connection = new ConnectionFactory();
        $query = "UPDATE  tbtest  SET url = NULL WHERE codigo = :id";
        $this->connection->beginTransaction();
        $retorno = array();

        try{
            $stmt = $this->connection->prepare( $query );
            $stmt->bindValue(":id", $values['id'], PDO::PARAM_INT);
            $stmt->execute();
            $this->connection->commit();
            $r = $stmt->errorInfo();

           // echo "Teste: ".$teste."\n<br>";
            if( $r[2] == null  ){
                //echo "remover: \n";

                $retorno = array(
                    'msg'    => 'Arquivo removido com sucesso!',
                    'id'     => $values['id'],
                    'status' => true
                );
            }else{
                new PDOException($r[2]);
            }
        }catch (PDOException $exception){
            $retorno = array(
                'msg'    => 'Problema: '.$exception->getMessage(),
                'id'     => 0,
                'status' => false
            );
        }

        return $retorno;

    }

    public function listar (){
        $this->connection = new ConnectionFactory();
        $query = "SELECT * FROM  tbtest";
        $this->connection->beginTransaction();
        $retorno = array();
        try{
            $stmt = $this->connection->prepare( $query );
            $stmt->execute();
            $this->connection->commit();
            if( $stmt->rowCount() > 0 ){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $retorno[] = array(
                        'codigo'   => $row['codigo'],
                        'nome'     => $row['name'],
                        'url'      => $row['url']
                    );
                }
            }

        }catch (PDOException $exception){

        }
        return $retorno;

    }

    public function updatePath ($values){
        $this->connection = new ConnectionFactory();
        $query = "UPDATE  tbtest  SET  url = :url WHERE codigo = :id";
        $this->connection->beginTransaction();
        $retorno = array();
        try{
            $stmt = $this->connection->prepare( $query );
            $stmt->bindValue(":url", $values['url'], PDO::PARAM_STR);
            $stmt->bindValue(":id", $values['id'], PDO::PARAM_INT);
            $stmt->execute();
            $this->connection->commit();
            $r = $stmt->errorInfo();
            if( $r[2] != null  ){
                $retorno = array(
                    'msg'    => 'Alterado com sucesso!',
                    'id'     => $values['id'],
                    'status' => true
                );
            }else{
                new PDOException($r[2]);
            }
        }catch (PDOException $exception){
            $retorno = array(
                'msg'    => 'Problema: '.$exception->getMessage(),
                'id'     => 0,
                'status' => false
            );
        }
        return $retorno;

    }


}