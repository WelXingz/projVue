<?php
function connect(){
    try
    {
        $pdo = new PDO( 'mysql:host=localhost;dbname=empresav','root','');
    }
    catch ( PDOException $e )
    {
        echo 'Oooops, algo não deu muito certo > ' . $e->getMessage();
    }
    return $pdo;
}

function buscarfuncionarios(){
    try{
    $pdo=connect();
    $buscarfuncionarios = $pdo->prepare("SELECT * from funcionarios");
    $buscarfuncionarios->execute();
    }catch ( PDOExcpetion $errorbuscarfuncionario ){
        echo "Ooops, erro ao inserir o funcionário na tabela!". $errorbuscarfuncionario->getMessage();
    }
    return $buscarfuncionarios;
}

function insert($nome, $funcao, $endereco, $telefone) {
    try {
    $pdo=connect();
    $inserir = $pdo->prepare("INSERT INTO funcionarios (nome, funcao, endereco, telefone) VALUES (:nome, :funcao, :endereco, :telefone)");
    $inserir->bindValue (':nome', $nome, PDO::PARAM_STR);
    $inserir->bindValue (':funcao', $funcao, PDO::PARAM_STR);
    $inserir->bindValue (':endereco', $endereco, PDO::PARAM_STR);
    $inserir->bindValue (':telefone', $telefone, PDO::PARAM_STR);
    $inserir->execute();
    }catch(  PDOException $errorinsert ){
        echo "Ooops, erro ao inserir o funcionário na tabela!". $errorinsert->getMessage();
    }

}

function atualizar($nome, $funcao, $endereco, $telefone, $id) {
    try{
        $pdo=connect();
        $atualizar = $pdo->prepare("UPDATE funcionarios SET nome = :nome, funcao = :funcao, endereco = :endereco, telefone = :telefone WHERE id=:id");
        $atualizar->bindValue (':nome', $nome, PDO::PARAM_STR);
        $atualizar->bindValue (':funcao', $funcao, PDO::PARAM_STR);
        $atualizar->bindValue (':endereco', $endereco, PDO::PARAM_STR);
        $atualizar->bindValue (':telefone', $telefone, PDO::PARAM_STR);
        $atualizar->bindValue (':id', $id, PDO::PARAM_STR);
        $atualizar->execute();
    }catch(  PDOException $erroratt ){
        echo "Ooops, erro ao atualizar o funcionário na tabela!". $erroratt->getMessage();
    }

}

function deletar($id) {
    try{
        $pdo=connect();
        $deletar = $pdo->prepare("DELETE FROM funcionarios WHERE id=:id");
        $deletar->bindValue (':id', $id, PDO::PARAM_STR);
        $deletar->execute();
    }catch(  PDOException $errordel ){
        echo "Ooops, erro ao atualizar o funcionário na tabela!". $errordel->getMessage();
    }
}

function sair(){
    session_destroy();
    header("location:index.html");
}
if (isset($_POST['inserirfuncionario'])){
    insert($_POST['nome'], $_POST['funcao'], $_POST['endereco'], $_POST['telefone']);
}
if (isset($_POST['atualizarfuncionario'])){
    atualizar($_POST['nome'], $_POST['funcao'], $_POST['endereco'], $_POST['telefone'], $_POST['id']);
}
if (isset($_POST['deletarfuncionario'])){
    deletar($_POST['id']);
}
if (isset($_POST['sair'])){
    sair();
}




 ?>
