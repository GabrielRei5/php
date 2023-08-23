<?php
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Programa...: instensinoniveiseducalterar (instensinoniveiseducalterar.php)
# DescriÃ§Ã£o..: Este Ã© um PA recursivo com 3 blocos. Inicialmente executa arquivo externo (require_once()) catalogo.php e instensinoniveiseducfuncoes.php. Executa a funÃ§Ã£o
#              sistÃªmica iniciapagina(), atribui valor na variÃ¡vel de controle de recursividade ($bloco) e as variveis de controle de navegaÃ§Ã£o
#              ($sair e $menu). A seguir EXECUTA a funÃ§Ã£o montamenu(). A seguir apresenta trÃªs blocos lÃ³gicos de programaÃ§Ã£o: Um blobo para escolha do registro
#              que serÃ¡ alterado, o segundo bloco monta um formulÃ¡rio com os dados do registro lido nos respectivos campos para ediÃ§Ã£o. No terceiro bloco faz
#              o tratamento de transaÃ§Ã£o para o comando UPDATE.
# Objetivo...: Gerenciar a funcionalidade ALTERAR dados de um registro escolhido da tabela 'instensinoniveiseduc'.
# Autor......: GRDS
# Criação....: 2023-05-26
# 
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Referenciando o arquivo catalogo.php
require_once("../../funcoes/catalogo.php");
# Referenciando o arquivo instensinoniveiseducfuncoes.php
require_once("./instensinoniveiseducfuncoes.php");
iniciapagina(TRUE,"InstEnsinoNiveisEduc","instensinoniveiseduc","Alterar");
# Determinando variÃ¡veis de controle: $bloco $menu e $sair
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
# Executando funÃ§Ã£o que monta o menu no topo da tela
montamenu("Alterar",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
# Com o comando a seguir se faz a execuÃ§Ã£o seletiva dos blocos de comandos: montagem do form e controle da transaÃ§Ã£o com base no valor de $bloco.
switch (TRUE)
{
  case ($bloco==1):
  { # NESTE case a picklist monta a tela com a caixa de seleÃ§Ã£o para escolha do registro.
    picklist("Alterar");
    break;
  }
  case ($bloco==2):
  { # NESTE case se faz a leitura do registro da tabela instensinoniveiseduc, com o registro lido se monta um formulÃ¡rio com os dados nos campos para ediÃ§Ã£o.
    #
    # Lendo o registro da tabela 'instensinoniveiseduc'
    # Note que neste comando se executa o '_fetch_query()' dentro do '_fetch_array()'. O '_fetch_query()' retorna somente UMA linha pois consulta
    # o registro pela chave primÃ¡ria da tabela. EntÃ£o o '_fetch_array()' sÃ³ precisa 'vetorizar' um registro para $reg[]. 
    $reglido=mysqli_fetch_array(mysqli_query($link,"SELECT * FROM instensinoniveiseduc WHERE pkinstensinoniveiseduc='$_REQUEST[pkinstensinoniveiseduc]'"));
    # montando o form. O form deve 'passar' o valor do cÃ³digo da instensinoniveiseduc em modo OCULTO (hidden).
    printf("<form action='instensinoniveiseducalterar.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='3'>\n");
    printf(" <input type='hidden' name='sair' value='$sair'>\n");
    printf(" <input type='hidden' name='pkinstensinoniveiseduc' value='$_REQUEST[pkinstensinoniveiseduc]'>\n");
	# Os campos do form devem aparecer na coluna da DIREITA de uma tabela.
    # Na coluna da ESQUERDA se exibe os textos que devem orientar o usuÃ¡rio na digitaÃ§Ã£o de valores nos campos.
    # Os campos do form podem ser preenchidos com os valores do registro de instensinoniveiseduc atravÃ©s do uso do atributo HTML 'value'.
    printf("<table>");

    # Montando a Picklist para a instituicoesensino (tabela:instituicoesensino)
	# a cx de seleÃ§Ã£o deve 'mostrar' a linha com a escolha prÃ© estabelecida no valor da chave primÃ¡ria da tabela instituicoesensino
    # (gravada no valor da chave estrangeira em instensinoniveiseduc - que estÃ¡ no vetor $reglido[fkinstituicao].
    # NOTE entÃ£o a comparaÃ§Ã£o $reglido[fkinstituicao]==$reg[pkinstituicao] atribuindo valor na variÃ¡vel $seleted
    # Esta comparaÃ§Ã£o deve ser feita 'dentro' do laÃ§o de repetiÃ§Ã£o que monta as linhas da cx de seleÃ§Ã£o.
    printf("<tr><td>Instituição:</td>     <td>");
    $cmdsql="SELECT pkinstituicao,txnomeinstituicao from instituicoesensino order by txnomeinstituicao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkinstituicao'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    { # LaÃ§o de RepetiÃ§Ã£o montando as linhas da Cx de SeleÃ§Ã£o
      # Eis o comando que verifica se existe igual entre $reglido[fkinstituicao] e $reg[pkinstituicao]. Se sim coloca "SELETED" na variÃ¡vel.
      $selected=( $reg['pkinstituicao']==$reglido['fkinstituicao'] ) ? " SELECTED": "" ;
      printf("<option value='$reg[pkinstituicao]'$selected>$reg[txnomeinstituicao]-($reg[pkinstituicao])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    # Note: TODA a cx de seleÃ§Ã£o foi 'montada' na coluna da direita da tabela.
	# Daqui para frente, praticamente acontece a repetiÃ§Ã£o do segmento de cÃ³digo anterior.
    #
    # Montando a Picklist para a Escola de FormaÃ§Ã£o do MÃ©dico (tabela:escolas)
    printf("<tr><td>Nivel de Ensino:</td><td>");
    $cmdsql="SELECT pkniveleducacao,txnomecomum from niveisdeeducacao order by txnomecomum";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkniveiseducacao'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      $selected=( $reg['pkniveleducacao']==$reglido['fkniveleducacao'] ) ? " SELECTED": "" ;
    printf("<option value='$reg[pkniveleducacao]'$selected>$reg[txnomecomum]-($reg[pkniveleducacao])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td></td>                                        <td><hr></td></tr>\n");
    printf("<tr><td>Telefone:</td>  <td><input type='text' name='nutelefone' value='$reglido[nutelefone]' placeholder='Apenas numeros' size='13' maxlength='13'></td></tr>\n");
    printf("   <tr><td>Cadastrado em:</td>                       <td><input type='date' name='dtcadinstensniveleduc' value='$reglido[dtcadinstensniveleduc]'></td></tr>\n");
    printf("<tr><td></td>                                        <td><hr></td></tr>\n");

	botoes("Alterar",TRUE,TRUE); # Reescrito no arquivo de instensinoniveiseducfuncoes.php. ParÃ¢metros: AÃ§Ã£o | Limpar | Voltar
    printf("</td></tr>\n");
    printf("</table>");
    printf("</form>");
    break;
  }
  case ($bloco==3):
  { # tratamento da transaÃ§Ã£o.
    # Este bloco Ã© muito semelhante so outros blocos de tratamento de transaÃ§Ã£o que jÃ¡ vimos.
    # PORÃ‰M o bloco de INSERT tem o comando montado DENTRO da transaÃ§Ã£o.
    # Por este motivo este segmento de cÃ³digo nÃ£o precisa ser 'migrado' para uma funÃ§Ã£o 'local'
    # construÃ§Ã£o do comando de atualizaÃ§Ã£o.
    $cmdsql="UPDATE instensinoniveiseduc
                    SET fkinstituicao            = '$_REQUEST[fkinstituicao]',
                        fkniveiseducacao             = '$_REQUEST[fkniveiseducacao]',
                        nutelefone    = '$_REQUEST[nutelefone]',
                        dtcadinstensniveleduc   = '$_REQUEST[dtcadinstensniveleduc]'
                    WHERE
                        pkinstensinoniveiseduc='$_REQUEST[pkinstensinoniveiseduc]'";
    # printf("$cmdsql<br>\n");
    $mostrar=FALSE;
    $tenta=TRUE;
    while ( $tenta )
    { # laÃ§o de controle de exec da trans.
      mysqli_query($link,"START TRANSACTION");
      # execuÃ§Ã£o do cmd.
      mysqli_query($link,$cmdsql);
      # tratamento dos erros de exec do cmd.
      if ( mysqli_errno($link)==0 )
      { # trans pode ser concluÃ­da e nÃ£o reiniciar
        mysqli_query($link,"COMMIT");
        $tenta=FALSE;
        $mostrar=TRUE;
        $mens="Registro com código $_REQUEST[pkinstensinoniveiseduc] Alterado!";
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
    {
      mostraregistro("$_REQUEST[pkinstensinoniveiseduc]");
    }
    break;
  }
}
terminapagina("instensinoniveiseduc","Alterar","instensinoniveiseducalterar.php");
?>