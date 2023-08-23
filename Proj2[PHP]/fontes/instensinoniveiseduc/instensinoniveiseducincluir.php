<?php
###############################################################################################################################################################
# Programa...: instensinoniveiseducincluir (instensinoniveiseducincluir.php)
# DescriÃ§Ã£o..: Inclui a execuÃ§Ã£o de arquivo externo (require_once()), identifica valor de variÃ¡vel de controle de recursividade
#              e apresenta dois blocos lÃ³gicos de programaÃ§Ã£o: Um blobo para montagem de um formulÃ¡rio para dados de mÃ©dicos e
#              um bloco para controlar o tratamento de uma trransaÃ§Ã£o.
# Objetivo...: Gerenciar a funcionalidade "incluir" dados na tabela instensinoniveiseduc.
# Autor......: GRDS
# Criação....: 2023-05-26
#
###############################################################################################################################################################

require_once("../../funcoes/catalogo.php");
# Referenciando o arquivo instensinoniveiseducfuncoes.php
require_once("./instensinoniveiseducfuncoes.php");
# Determinando $bloco
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
# monstrando o valor de $bloco em cada execuÃ§Ã£o
# printf("$bloco<br>$sair<br>$menu\n");
iniciapagina(TRUE,"instensinoniveiseduc","instensinoniveiseduc","Incluir");
montamenu("Incluir",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
# As variÃ¡veis $bloco, $sair e $menu devem ser 'transmitidas' entre os PA sempre em campos de formulÃ¡rios em modo 'hidden'.
# Se for necessÃ¡rio verificar se algum form passa corretamente os valores em modo recursivo, RETIRE o comentÃ¡rio da linha no inÃ­cio deste bloco de comentÃ¡rio.
# Este comando printf() estÃ¡ escrito depois da execuÃ§Ã£o da funÃ§Ã£o montamenu porque o menu Ã© exibido em uma <DIV> no topo da tela.
###############################################################################################################################################################
# Com o comando a seguir se faz a execuÃ§Ã£o seletiva dos blocos de comandos: montagem do form e controle da transaÃ§Ã£o com base no valor de $bloco.
switch (TRUE)
{
  case ($bloco==1):
  { # montando o form
    
    printf("  <form action='instensinoniveiseducincluir.php' method='POST'>\n");
    printf("  <input type='hidden' name='bloco' value='2'>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("  <table>\n");
    printf("   <tr><td>Código:</td>         <td>O Código será gerado pelo Sistema</td></tr>\n");
    
    # Montando a Picklist para a seleção de instituição (tabela: instituicoesensino)
    printf("<tr><td>Instituição:</td>     <td>");
    $cmdsql="SELECT pkinstituicao, txnomeinstituicao from instituicoesensino order by txnomeinstituicao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkinstituicao'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[pkinstituicao]'>$reg[txnomeinstituicao]-($reg[pkinstituicao])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    # Montando a Picklist para niveis de educação (tabela: niveisdeeducacao)
    printf("<tr><td>Nivel de Educação:</td><td>");
    $cmdsql="SELECT pkniveleducacao,txnomecomum from niveisdeeducacao order by pkniveleducacao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkniveiseducacao'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[pkniveleducacao]'>$reg[txnomecomum]-($reg[pkniveleducacao])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td></td>                                        <td><hr></td></tr>\n");
    # Montando a Picklist para a Logradouro da ClÃ­nica do MÃ©dico (tabela: logradouros+logradourostipos na visÃ£o: logradouroscompletos)
  
    printf("   <tr><td>Telefone:</td>  <td><input type='text' name='nutelefone' placeholder='Apenas numeros' size='13' maxlenght='13'></td></tr>\n");
    printf("   <tr><td>Cadastrado em:</td>  <td><input type='date' name='dtcadinstensniveleduc'></td></tr>\n");
    printf("   <tr><td></td>                <td>");
    botoes("Incluir",TRUE,FALSE);
    printf("<tr><td></td>                                        <td><hr></td></tr>\n");
    # Reescrito no arquivo de instensinoniveiseducfuncoes.php. ParÃ¢metros: AÃ§Ã£o | Limpar | Voltar
#1 botoes($acao,$limpar,$voltar) Estes sÃ£o os parÃ¢metros de chamada da funÃ§Ã£o botÃµes
#2 Os comandos que montam as TAGS de montagem dos botÃµes de navegaÃ§Ã£o foram 'migradas' para a funÃ§Ã£o botoes().
#3 Note que alguns botÃµes foram muigrados para a funÃ§Ã£o montamenu().
#4 Ao desenvolver o SEU PA estas linhas de comentÃ¡rios 'numerados' podem ser removidas
#5    printf("<button class='nav' type='submit'                             >Salvar</button>\n"); # <font size=5>&#x1f5f9;</font>
#6    printf("<button class='nav' type='reset'                              >Limpar</button>\n"); # <font size=5>&#x2b6e;</font>
#7    printf("<button class='nav' type='button' onclick='history.go(-$menu)'>Abertura</button>\n"); # <font size=5>&#x1f3e0;&#xfe0e;</font>
#8    printf("<button class='nav' type='button' onclick='history.go(-$sair)'>Sair</button>\n"); # <font size=5>&#x2348;</font>
    printf("</td></tr>\n");
    printf("  </table>\n");
    printf("  </form>\n");
    break;
  }
  case ($bloco==2):
  { # Tratamento da transaÃ§Ã£o.
    # lendo os valores digitados nos campos do form
    # a transaÃ§Ã£o se inicia com o comando: START TRANSACTION
    # a transaÃ§Ã£o deve ser executada 'dentro' de um laÃ§o de repetiÃ§Ã£o.
    $mostrar=FALSE;
    $tenta=TRUE;
    while ( $tenta )
    { # laÃ§o de controle de exec da trans.
      mysqli_query($link,"START TRANSACTION");
      # ConstruÃ§Ã£o do comando de atualizaÃ§Ã£o. Isso deve ser feito '' da transaÃ§Ã£o porque, se algo der errado na atualizaÃ§Ã£o, outro nÃºmero da CP deve ser criado.
      # RecuperaÃ§Ã£o do Ãºltimo valor gravado na PK da tabela Usando a funÃ§Ã£o MAX (SQL) e as funÃ§Ãµes PHP '_query' e '_fetch_array' combinadas.
      $ultimacp=mysqli_fetch_array(mysqli_query($link,"SELECT MAX(pkinstensinoniveiseduc) AS CpMAX FROM instensinoniveiseduc"));
      $CP=$ultimacp['CpMAX']+1;
      # ConstruÃ§Ã£o do comando de atualizaÃ§Ã£o.
      $cmdsql="INSERT INTO instensinoniveiseduc (  pkinstensinoniveiseduc, fkinstituicao, fkniveiseducacao,
                                              nutelefone, dtcadinstensniveleduc)
                      VALUES ('$CP',
                              '$_REQUEST[fkinstituicao]',
                              '$_REQUEST[fkniveiseducacao]',
                              '$_REQUEST[nutelefone]',
                              '$_REQUEST[dtcadinstensniveleduc]')";
      # printf("$cmdsql<br>\n");
      # execuÃ§Ã£o do cmd.
      mysqli_query($link,$cmdsql);
      # tratamento dos erros de exec do cmd.
      if ( mysqli_errno($link)==0 )
      { # trans pode ser concluÃ­da e nÃ£o reiniciar
        mysqli_query($link,"COMMIT");
        $tenta=FALSE;
        $mostrar=TRUE;
        $mens="Registro incluído!";
      }
      else
      {
        if ( mysqli_errno($link)==1213 )
        { # abortar a trans e reiniciar
          $tenta=TRUE;
        }
        else
        { # abortar a trans e NÃƒO reiniciar
          $tenta=FALSE;
          $mens=mysqli_errno($link)."-".mysqli_error($link);
        }
        mysqli_query($link,"ROLLBACK");
        $mostrar=FALSE;
      }
    }
    printf("$mens<br>\n");
    if ( $mostrar )
    { # mostraregistro incova botoes que recebe os parÃ¢metros ($acao,$clear,$voltar,$menu,$sair)
      mostraregistro("$CP",);
      # como colocamos os botoes de Pular para Abertura e Sair do Sistema na barra do menu, entÃ£o precisamos mais executar nada da funÃ§Ã£o botoes().
    }
    break;
  }
}
terminapagina("InstEnsinoNiveisEduc","Incluir","instensinoniveiseducincluir.php");
?> 