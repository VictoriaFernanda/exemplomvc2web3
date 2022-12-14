<?php
//As classes DAO são responsáveis por executar o SQL em conjunto com o banco de dados.
namespace App\DAO;
use App\Model\ProdutoModel;
use \PDO;
class ProdutoDAO
{
    // Propriedade da classe que  armazenará o link de conexão com o banco de dados.

    private $conexao;


    public function __construct()
    {
        // O dsn é o endereço do servidor MySql
      $dsn = "mysql:host=localhost:3307;dbname=db_mvc";

      // Aqui está criando a conexão e armazenando em sua respectiva propriedade
        $this->conexao = new PDO($dsn, 'root', 'etecjau');
    }

   // Metódo que irá inserir as informações da Model no Banco de dados
    public function insert(ProdutoModel $model)
    {
           $sql = "INSERT INTO produto (nome, descricao, marca, valor) VALUES (?, ?, ?, ?) ";

            
        //Declaração da variável stmt que conterá a montagem da consulta. Observe que
        // estamos acessando o método prepare dentro da propriedade que guarda a conexão
        // com o MySQL, via operador seta "->". Isso significa que o prepare "está dentro"
        // da propriedade $conexao e recebe nossa string sql com os devidor marcadores.

  $stmt = $this->conexao->prepare($sql);


        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->descricao);
        $stmt->bindValue(3, $model->marca);
        $stmt->bindValue(4, $model->valor);
        $stmt->execute();
    }


  
    public function update(ProdutoModel $model)
    {
        $sql = "UPDATE produto SET nome=?, descricao=?, marca=?, valor=? WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->descricao);
        $stmt->bindValue(3, $model->marca);
        $stmt->bindValue(4, $model->valor);
        $stmt->bindValue(5, $model->id);
        $stmt->execute();
    }


    public function select()
    {
        $sql = "SELECT * FROM produto ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);        
    }


   
    public function selectById(int $id)
    {
        include_once 'Model/ProdutoModel.php';

        $sql = "SELECT * FROM produto WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchObject("ProdutoModel"); 
    }


   
    public function delete(int $id)
    {
        $sql = "DELETE FROM produto WHERE id = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}