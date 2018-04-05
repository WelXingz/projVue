<?php
include('funcoes.php');
$pdo=connect();
session_start();

$usuario=$_POST['usuario'];
$senha=$_POST['senha'];
$buscar=$pdo->prepare("SELECT * FROM login WHERE usuario=:usuario AND senha=:senha");
$buscar->bindValue (':usuario', $usuario, PDO::PARAM_STR);
$buscar->bindValue (':senha', $senha, PDO::PARAM_STR);
$buscar->execute();
if ($buscar->rowCount() > 0 ){
    $_SESSION ['usuario'] = $usuario;
    $_SESSION ['senha'] = $senha;
    echo "logado";
}else{
    echo "usuário ou senha inválidos!";
}
 ?>
