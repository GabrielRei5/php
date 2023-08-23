<?php
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Programa.: instensinoniveiseduclistar (arquivo instensinoniveiseduclistar.php)
# Descrição: Este PA tem 2 'cases' com tres valores de $bloco. No primeiro case monta um form para escolha da ordenacao dos dados de instensinoniveiseduc que serao
#            exibidos na listagem, nos cases 2 e 3 monta uma tabewla com os dados de uma juncao completa entre instensinoniveiseduc e todas as tabelas relacionadas.
#            Note o comando SQL que faz a juncao e deste modo faz o SGBD trabalhar para o PA.
# Objetivo.: Montar a Listagem de dados da tabela instensinoniveiseduc.
# Autor....: GRDS
# Criação..: 2023-05-26
# 
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
require_once("../../funcoes/catalogo.php");
require_once("./instensinoniveiseducfuncoes.php");
# Neste PA o menu deve ser montado somente no primeiro bloco de execução
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
$bloco=( ISSET($_POST['bloco']) ) ? $_POST['bloco'] : 1;
$cordefundo=($bloco<3) ? TRUE : FALSE;
iniciapagina($cordefundo,"InstEnsinoNiveisEduc","instensinoniveiseduc","Listar");

# Com o comando a seguir se faz a execução seletiva dos blocos de comandos: montagem do form e Montagem da Listagem.
switch (TRUE)
{
  case ( $bloco==1 ):
  { # este bloco monta o form e passa o bloco para o valor 2 em modo oculto
    # Aqui se executa a função montamenu(). O menu deve ser apresentado nos 'cases' 1 e 2... o 'case' deve exibir a listagem SEM o menu.
    montamenu("Listar","$sair");
    printf(" <form action='./instensinoniveiseduclistar.php' method='post'>\n");
    printf("  <input type='hidden' name='bloco' value=2>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("  <table>\n");
    printf("   <tr><td colspan=2>Escolha a <b>ordem</b> como os dados serão exibidos no relatório:</td></tr>\n");
    printf("   <tr><td>Código da InstEnsinoNiveisEduc:</td><td>(<input type='radio' name='ordem' value='T.pkinstensinoniveiseduc'>)</td></tr>\n");
    printf("   <tr><td>Nome da Instituição:</td><td>(<input type='radio' name='ordem' value='I.txnomeinstituicao' checked>)</td></tr>\n");
    printf("   <tr><td colspan=2>Escolha valores para seleção de <b>dados</b> do relatório:</td></tr>\n");
    printf("   <tr><td>Escolha uma Instituição:</td><td>");
    $cmdsql="SELECT pkinstituicao,txnomeinstituicao from instituicoesensino order by txnomeinstituicao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkinstituicao'>");
    printf("<option value='TODAS'>Todas</option>");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[pkinstituicao]'>$reg[txnomeinstituicao]-($reg[pkinstituicao])</option>");
    }
    printf("<select>\n");
    printf("</td></tr>\n");
    $dtini="1901-01-01";
    $dtfim=date("Y-m-d");
    printf("<tr><td>Intervalo de datas de cadastro:</td><td><input type='date' name='dtcadini' value='$dtini'> até <input type='date' name='dtcadfim' value='$dtfim'></td></tr>");
    printf("   <tr><td></td><td>");
    botoes("Listar",FALSE,TRUE); 
    
    printf("</td></tr>\n");
    printf("  </table>\n");
    printf(" </form>\n");
    break;
  }
  case ( $bloco==2 || $bloco==3 ):
  { # Este bloco vai processar a junção de instensinoniveiseduc com instituicaoensino e niveisdeeducacao.
    # Depois monta a tabela com os dados e a seguir um form permitindo que a listagem seja exibida para impressão em uma nova aba.
    $selecao=" WHERE (T.dtcadinstensniveleduc between '$_REQUEST[dtcadini]' and '$_REQUEST[dtcadfim]')";
    $selecao=( $_REQUEST['fkinstituicao']!='TODAS' ) ? $selecao." AND T.fkinstituicao='$_REQUEST[fkinstituicao]'" : $selecao ;
	# Na base de dados de exemplo existe a implementação de uma visão que faz toda as junções necessárias de 'instensinoniveiseduc' e as tabelas relacionadas.  
    $cmdsql="SELECT * FROM instensinoniveiseduc AS T LEFT JOIN instituicoesensino AS I ON T.fkinstituicao = I.pkinstituicao LEFT JOIN niveisdeeducacao AS N ON T.fkniveiseducacao = N.pkniveleducacao".$selecao." ORDER BY $_REQUEST[ordem]";
    # printf("<br><br><br><br>$cmdsql<br>\n");
	# Lendo os dados do banco de dados.
    $execsql=mysqli_query($link,$cmdsql);
    # SE o bloco de execução for 2, então o menu DEVE aparecer no topo da tela.
    ($bloco==2) ? montamenu("Listar","$_REQUEST[sair]") : printf("<div class='body-rel'>\n");
	# O operador ternário foi usado acima de um modo 'diferente' executando uma função de modo condicional
	# Abaixo se inicia a construção da tabela com os dados lidos. A Listagem NÃO terá um contador de linhas para formatar os saltos de páginas...
	# Mas isso até que seria interessante implementar... Talvez...
    
    printf("<table border=1 style=' border-collapse: collapse; '>\n");
	# Aqui se monta o cabeçalho da tabela. Note que existe uma linha dupla para mostrar os dados de Instituição e Nivel de Educação 'agrupados'.
    printf(" <tr><td valign=top rowspan=2>Cod.</td>\n");
    printf("     <td valign=top colspan=6>Instituicao</td>\n");
    printf("     <td valign=top colspan=3>Nivel de Educação</td>\n");
    printf("     <td valign=top rowspan=2>Telefone</td>\n");
    printf("     <td valign=top rowspan=2>Data de Cadastro</td></tr>\n");
    printf(" <tr><td valign=top>Nome</td>\n");
    printf("     <td valign=top>Logradouro</td>\n");
    printf("     <td valign=top>Complemento</td>\n");
    printf("     <td valign=top>CEP</td>\n");
    printf("     <td valign=top>Data de Fundação</td>\n");
    printf("     <td valign=top>Data de Cad. InstEns</td>\n");
    printf("     <td valign=top>Nome Comum</td>\n");
    printf("     <td valign=top>Anos de Estudo</td>\n");
    printf("     <td valign=top>Data de Cad. NivelEduc.</td></tr>\n");
	# Terminando o 'cabeçalho' segue o corpo da listagem com os dados. Esta listagem será Zebrada com as cores branca e lightgreen
    $corlinha="White";
    while ( $le=mysqli_fetch_array($execsql) )
    {
      printf("<tr bgcolor=$corlinha><td>$le[pkinstensinoniveiseduc]</td>\n");
      # campos de 'instensinoniveiseduc' que são chaves estrangeiras são exibidos com seus 'campos descritivos'.
      printf("   <td valign=top>$le[txnomeinstituicao]-($le[fkinstituicao])</td>\n");
      printf("   <td valign=top>$le[fklogradouro]</td>\n");
      printf("   <td valign=top>$le[txcomplemento]</td>\n");
      printf("   <td valign=top>$le[nucep]</td>\n");
      printf("   <td valign=top>$le[dtfundacao]</td>\n");
      printf("   <td valign=top>$le[dtcadinstituicaoensino]</td>\n");
      printf("   <td valign=top>$le[txnomecomum]-($le[fkniveiseducacao])</td>\n");
      printf("   <td valign=top>$le[qtanosdeestudo]</td>\n");
      printf("   <td valign=top>$le[dtcadniveleducacao]</td>\n");
      printf("   <td valign=top>$le[nutelefone]</td>\n");
	  # A data é exibida no formato AAAA-MM-DD. Pode deixar assim ou trabalhar com a função SUBSTRING() para exibir em outro formato.
      printf("   <td valign=top>$le[dtcadinstensniveleduc]</td></tr>\n");
      $corlinha=( $corlinha=="White" ) ? "lightgreen" : "White"; # Navajowhite | lightblue 
    }
    printf("</table>\n");
    if ( $bloco==2 )
    { # Aqui se monta o form que é apresentado no final da listagem permitindo a escolha de emitir a mesma listagem em nova aba SEM o MENU.
      
      printf("<form action='./instensinoniveiseduclistar.php' method='POST' target='_NEW'>\n");
      printf(" <input type='hidden' name='bloco' value=3>\n");
      printf(" <input type='hidden' name='sair' value='$sair'>\n");
      printf(" <input type='hidden' name='fkinstituicao' value=$_REQUEST[fkinstituicao]>\n");
      printf(" <input type='hidden' name='dtcadini' value=$_REQUEST[dtcadini]>\n");
      printf(" <input type='hidden' name='dtcadfim' value=$_REQUEST[dtcadfim]>\n");
      printf(" <input type='hidden' name='ordem' value=$_REQUEST[ordem]>\n");
      botoes("Imprimir",FALSE,TRUE); # Reescrito no arquivo de instensinoniveiseducfuncoes.php. Parâmetros: Ação | Limpar | Voltar
      printf("</form>\n");
    }
    else
    {
      printf("<hr>\n<button class='imp' type='submit' onclick='window.print();'>Imprimir</button> - Corte a folha na linha acima.\n");
    }
    break;
  }
}
terminapagina("instensinoniveiseduc","Listar","instensinoniveiseduclistar.php");
?>