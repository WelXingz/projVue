<?php
include("funcoes.php");
header('Content-Type: text/html; charset=utf-8');
$pdo=connect();
session_start();
$pdo->query("SET NAMES 'utf8'");
if  (!isset($_SESSION ['usuario']) && !isset($_SESSION ['senha'])){
    header('Location:index.html');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <style>
            body{
                background-color:#000;
            }
            .table {
                width:80%;
                margin-left:10%;
            }
            .table td, .table th{
               border-color: black;
               text-align:center;
            }
            label{
                display:block;
            }
            a {
                cursor:pointer;
            }
            i{
                vertical-align:middle;
            }
            button {
                 background:none;
                 color:inherit;
                 border:none;
                 padding:0;
                 font: inherit;
                 cursor: pointer;
            }
            form {
                display:inline;
            }

        </style>
    </head>
    <body>
        <br>
        <a data-toggle="modal" data-target="#modalinserir" style="color:#1FC; margin-left:10%;">Adicionar funcionário<i class="material-icons">add</i></a>
        <form method="post" id="sair" onsubmit="submitform(this.id)">
            <button type="submit" name="sair" style="color:#F16; margin-right:10%;float:right;">Sair<i class="material-icons">highlight_off</i></button>
        </form>
        <span class="oi" data-glyph="plus"></span>
        <div class="modal fade" tabindex="-1" id="modalinserir" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Adicionar funcionário</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirfuncionario" onsubmit="submitform(this.id)">
                            <label>Nome</label>
                            <input type="text" name="nome">
                            <label>Funcão</label>
                            <input type="text" name="funcao">
                            <label>Endereço</label>
                            <input type="text" name="endereco">
                            <label>Telefone</label>
                            <input type="text" name="telefone" ><br><br>
                            <input type="submit" class="btn btn-primary" value="Inserir" name="inserirfuncionario">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-dark">
            <th>Atualizar/Excluir</th>
            <th>Nome</th>
            <th>Função</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <?php
            $i = 0;
            $buscarfuncionarios = buscarfuncionarios();
            while($linha = $buscarfuncionarios->fetch(PDO::FETCH_ASSOC)){
                $i = $i + 1;
                modal($i, $linha['ID']);
                ?>
                <tr id="linhatabela<?=$i?>">
                        <td>
                            <a data-toggle="modal" data-target="#modalatualizar<?=$i?>"><i class="material-icons">autorenew</i></a>
                            <form method="post" id="deletarfuncionario" onsubmit="submitform(this.id)">
                                <input type="hidden" value="<?=$linha['ID']?>" name="id"/>
                                <button type="submit" name="deletarfuncionario"><i class='material-icons'>clear</i></button>
                            </form>
                        </td>
                        <td v-for="colunas in funcionario">
                             {{ colunas.nome }} {{ colunas.funcao }} {{ colunas.endereco }} {{ colunas.telefone }}
                        </td>
                </tr>
                <script>
                  var linhatabela = new Vue({
                      el: '#linhatabela<?=$i?>',
                      data: {
                          funcionario: [
                              {nome: "<?=$linha['nome']?>"},
                              {funcao: "<?=$linha['funcao']?>"},
                              {endereco: "<?=$linha['endereco']?>"},
                              {telefone: "<?=$linha['telefone']?>"}
                          ]
                      }
                  })
                </script>

                <?php
            }
            ?>

        </table>
    </body>
</html>
<script>
function submitform (id){
    $(id).submit(function(e) {
        $.ajax({
               type: "POST",
               url: "funcoes.php",
               data: $(id).serialize(),
               success: function(data)
               {
                   alert(data);
               }
             });
        e.preventDefault();
    });
}
</script>
<?php
function modal($i, $id){
?>
    <div class="modal fade" id="modalatualizar<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Atualizar Funcionário ID <?=$id?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form method="post" id="atualizarfuncionario" onsubmit="submitform(this.id)">
                  <label>Atualizar Nome</label>
                  <input type="text" name="nome">
                  <label>Atualizar Função</label>
                  <input type="text" name="funcao">
                  <label>Atualizar Endereço</label>
                  <input type="text" name="endereco">
                  <label>Atualizar Telefone</label>
                  <input type="text" name="telefone" ><br><br>
                  <input type="hidden" value="<?=$id?>" name="id">
                  <input type="submit" class="btn btn-primary" value="Atualizar" name="atualizarfuncionario">
              </form>
          </div>
        </div>
      </div>
    </div>
<?php
}
?>
