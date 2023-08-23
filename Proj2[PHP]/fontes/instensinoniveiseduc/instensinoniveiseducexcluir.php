<?php
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Programa.: instensinoniveiseducexcluir (instensinoniveiseducexcluir.php)
# Objetivo.: Gerenciar a funcionalidade "excluir" dados no gerenciamento de dados da Tabela (instensinoniveiseduc) Referenciada para estudo.
# Descrição: Programa Recursivo. Executa arquivos externos (require_once() para catalogo.php e instensinoniveiseducfuncoes.php), identifica valor de variável de controle
#            de recursividade e apresenta três blocos lógicos de programação:
#            - montagem de um formulário para escolha de dados de médicos
#            - exibir od dados digitados e
#            - tratamento de uma transação (atualização dos dados da tabela).
# Autor....: GRDS
# Criação..: 2023-05-26
# 
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Este é um exemplo de um programa recursivo. Neste código-fonte resolvi retirar a maioria dos comentários.
# Referenciando o arquivo toolskit.php e o instensinoniveiseducfuncoes.php
require_once("../../funcoes/catalogo.php");
require_once("./instensinoniveiseducfuncoes.php");
iniciapagina(TRUE,"InstEnsinoNiveisEduc","instensinoniveiseduc","Excluir");
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
montamenu("Excluir",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
switch (TRUE)
{
  case ($bloco==1):
  { # Executa a função de picklist para escolha do registro a excluir
    picklist("Excluir");
    break;
  }
  case ($bloco==2):
  { # mostra o registro que será excluído e pede confirmação do usuário.
    mostraregistro("$_REQUEST[pkinstensinoniveiseduc]");
    printf("<form action='instensinoniveiseducexcluir.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='3'>\n");
    printf(" <input type='hidden' name='sair' value='$sair'>\n");
    printf(" <input type='hidden' name='pkinstensinoniveiseduc' value='$_REQUEST[pkinstensinoniveiseduc]'>\n");
	botoes("Excluir",FALSE,TRUE); # Reescrito no arquivo de instensinoniveiseducfuncoes.php. Parâmetros: Ação | Limpar | Voltar
    printf("</form>");
    break;
  }
  case ($bloco==3):
  { # tratamento da transação.
    # construção do comando de atualização.
    $cmdsql="DELETE FROM instensinoniveiseduc WHERE instensinoniveiseduc.pkinstensinoniveiseduc='$_REQUEST[pkinstensinoniveiseduc]'";
    # printf("$cmdsql<br>\n");
    $mostrar=FALSE;
    $tenta=TRUE;
    while ( $tenta )
    { # laço de controle de exec da trans.
      mysqli_query($link,"START TRANSACTION");
      # execução do cmd.
      mysqli_query($link,$cmdsql);
      # tratamento dos erros de exec do cmd.
      if ( mysqli_errno($link)==0 )
      { # trans pode ser concluída e não reiniciar
        mysqli_query($link,"COMMIT");
        $tenta=FALSE;
        $mostrar=TRUE;
        $mens="Registro com código $_REQUEST[pkinstensinoniveiseduc] excluído!";
      }
      else
      {
        if ( mysqli_errno($link)==1213 )
        { # abortar a trans e reiniciar
          $tenta=TRUE;
        }
        else
        { # abortar a trans e NÃO reiniciar
          $tenta=FALSE;
          $mens=mysqli_errno($link)."-".mysqli_error($link);
        }
        mysqli_query($link,"ROLLBACK");
        $mostrar=FALSE;
      }
    }
    printf("$mens<br>\n");
    break;
  }
}
terminapagina("instensinoniveiseduc","Excluir","instensinoniveiseducexcluir.php");
?>