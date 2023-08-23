<?php
ini_set('display_errors', 1);

#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Programa.: instensinoniveiseducfuncoes.php
# Objetivo.: Armazenar o conjunto de funções 'locais' de suporte ao gerenciamento de dados da tabela 'instensinoniveiseduc'
# Descricao: Programa com a declaração das funções 'locais': picklist(), mostraregistro(), montamenu() e botoes() que dão suporte ao
#            Gerenciamento de dados da Tabela (instensinoniveiseduc) Referenciada para estudo.
# Autor....: GRDS
# Criacao..: 2023-05-26
# 
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
function picklist($acao)
{ #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # Monta a caixa de seleção para escolha de um médico para as funcionalidades de consulta, exclusão ou alteração.
  # Esta função tem os parâmetros:
  # $acao.: Texto com o nome da funcionalidade ("Consultar","Alterar" ou "Excluir").
  #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # globalizando uma variavel de conexão
  global $link;
  # determinando o NOME do PA que será chamado (recursivamente) pela função
  $prg=($acao=="Consultar") ? "instensinoniveiseducconsultar.php" : (($acao=="Alterar") ? "instensinoniveiseducalterar.php" : "instensinoniveiseducexcluir.php" ) ;
  # Atribuindo valores em $sair e $menu (variáveis usadas na função que monta a barra de botões) e que devem ser 'transmitidas'
  # para o PA seguinte que executa esta função.
  $sair=$_REQUEST['sair']+1;
  $menu=$_REQUEST['sair'];
  $btacao=($acao=="Consultar") ? "Consultar" : (($acao=="Alterar") ? "Alterar": "Excluir" );  # Consultar-&#x1f50d;&#xfe0e; | Alterar-&#x1f589; | Excluir-&#x1f5f7;
  /* desenhos dos botões:         Lupa                                        Lápis        'X' de excluir */
  printf("  <form action='./$prg' method='POST'>\n");
  printf("  <input type='hidden' name='bloco' value='2'>\n");
  printf("  <input type='hidden' name='sair' value='$sair'>\n");
  # Lendo os dados de instensinoniveiseduc para montar uma picklist de escolha do instituição a consultar
  $cmdsql="SELECT pkinstensinoniveiseduc, fkinstituicao, txnomeinstituicao, dtcadinstensniveleduc FROM instensinoniveiseduc AS i inner join instituicoesensino AS e on i.fkinstituicao=e.pkinstituicao ORDER BY dtcadinstensniveleduc";
  # printf("$cmdsql<br>\n");
  $execcmd=mysqli_query($link,$cmdsql);
  printf("<select name='pkinstensinoniveiseduc'>\n");
  $ceespec="";
  while ( $registro=mysqli_fetch_array($execcmd) )
  { # laço para 'montar' as linhas de option da picklist
    printf("<option value='$registro[pkinstensinoniveiseduc]'>$registro[txnomeinstituicao] - $registro[dtcadinstensniveleduc] - ($registro[pkinstensinoniveiseduc])</option>\n");
  }
  printf("</optgroup>\n");
  printf("</select>\n");
  botoes($acao,TRUE,FALSE);
  # Parametros na ordem: ($acao,$limpar,$voltar,$menu,$sair) - Nome da ação | TRUE ou FALSE | TRUE ou FALSE | saltos para ABERTURA | saltos para SAIR
#  printf("<button class='nav' type='submit'                             >$btacao</button>\n");
#  printf("<button class='nav' type='button' onclick='history.go(-$menu)'>Abertura</button>\n"); # &#x1f3e0;&#xfe0e;
#  printf("<button class='nav' type='button' onclick='history.go(-$sair)'>Sair</button>\n"); # &#x2348;
  printf("  </form>\n");
}
function mostraregistro($CP)
{ #--------------------------------------------------------------------------------------------------------------------------------------------------
  # Função.....: mostraregistro
  # Objetivo...: Receber o valor da Chave Primária da tabela 'instensinoniveiseduc' e apresentar os dados do registro em uma tabela HTML.
  # Descricao..: O parâmetro $CP recebe o valor da CP da tabela 'instensinoniveiseduc'. A função executa a leitura do registro com um comando SQL de SELEÇÃO.
  #              Os dados do registro são vetorizados na função usando a função de ambiente fetch_array da PHP. A seguir são emitidas as TAGs que
  #              montam uma tabela HTML com os dados. NOTE o comando SQL que tras os dados da tabela... vale a pena estudá-lo.
  # Parametros.: Esta Funcao recebe os parametros:
  #              $CP - valor da chave primária da tabela instensinoniveiseduc.
  # Autor......: JMH - Use! Mas fale quem fez!
  # Criação....: 2020-02-10
  # Atualização: 2020-02-10 - Desenvolvimento e teste da funcao.
  #--------------------------------------------------------------------------------------------------------------------------------------------------
  # função que recebe o código da instensinoniveiseduc e exibe o registro.
  global $link;
  $cmdsql="SELECT * FROM instensinoniveiseduc AS T LEFT JOIN instituicoesensino AS I ON T.fkinstituicao = I.pkinstituicao LEFT JOIN niveisdeeducacao AS N ON T.fkniveiseducacao = N.pkniveleducacao WHERE pkinstensinoniveiseduc = '$CP'";
  
  # SE o comando apresentar algum erro pode ser interessante 'ver' o comando na tela do navegador. Para isso RETIRE o comentário da próxima linha.
  # printf("$cmdsql<br>\n");
  $execcmd=mysqli_query($link,$cmdsql);
  $reg=mysqli_fetch_array($execcmd);
  printf("<table>\n");
  printf("    <tr><td>C&oacute;digo:</td>                    <td>$reg[pkinstensinoniveiseduc]</td>                                     </tr>\n");
  printf("    <tr><td>Instituição:</td>                          <td>$reg[txnomeinstituicao] - ($reg[fkinstituicao])</td>                                 </tr>\n");
  printf("    <tr><td>Nivel de Educação:</td>                           <td>$reg[txnomecomum] - ($reg[fkniveiseducacao])</td>                                        </tr>\n");
  printf("    <tr><td>Telefone:</td>                 <td>$reg[nutelefone]</td>  </tr>\n");
  printf("    <tr><td colspan=2><hr>Instituição</td>                                                                         </tr>\n");
  printf("    <tr><td>Nome da Instituição:</td>                  <td>$reg[txnomeinstituicao]-($reg[fkinstituicao])</td></tr>\n");
  printf("    <tr><td>Logradouro:</td>                            <td>$reg[fklogradouro]</td>                         </tr>\n");
  printf("    <tr><td>Complemento:</td>                     <td>$reg[txcomplemento]</td>                                 </tr>\n");
  printf("    <tr><td>CEP:</td>          <td>$reg[nucep]</td>                                </tr>\n");
  printf("    <tr><td>Data de Fundação:</td>                   <td>$reg[dtfundacao]</td>                                </tr>\n");
  printf("    <tr><td>Data de Cadastro:</td>                   <td>$reg[dtcadinstituicaoensino]</td>                                </tr>\n");
  printf("    <tr><td colspan=2><hr>Nivel de Educação</td>                                                                  </tr>\n");
  printf("    <tr><td>Nome Comum:</td>                      <td>$reg[txnomecomum]-($reg[fkniveiseducacao])</td></tr>\n");
  printf("    <tr><td>Anos de Estudo:</td>                        <td>$reg[qtanosdeestudo]</td>                         </tr>\n");
  printf("    <tr><td>Data de Cadastro:</td>                     <td>$reg[dtcadniveleducacao]</td>                                 </tr>\n");
  printf("    <tr><td colspan=2><hr></td>                                                                                </tr>\n");
  printf("    <tr><td>Cadastrado em</td>                     <td>$reg[dtcadinstensniveleduc]</td>                                  </tr>\n");
  printf("    <tr><td></td><td></td></tr>\n");
  printf("</table>\n");
}
function montamenu($acao,$sair)
{ #--------------------------------------------------------------------------------------------------------------------------------------------------
  # Função.....: montamenu
  # Objetivo...: Montar o menu de acesso às funcionalidades do sistema.
  # Descricao..: Emite as TAGs que montam o menu de navegação na div suoerior da tela do sistema. No arquivo .CSS são definidas os seletores de DIVS
  #              para a região superior da tela e 'dentro' desta para os botões que formam o menu.
  # Parametros.: Esta Funcao recebe os parametros:
  #              $acao..: Texto indicando a ação do PA que executa a função montamenu().
  #              $sair..: Variável que controle a quantidade de saltos executados entre as funcionalidades.
  #                       É usada para administrar a construção da barra de botões de navegação.
  # Autor......: GRDS
  # Criação....: 2023-05-26
  # 
  #--------------------------------------------------------------------------------------------------------------------------------------------------
  printf("<div class='$acao fixed'>\n");
  printf(" <div class='menu'>\n");
  printf(" <form action='' method='POST'>\n");
  # A definição da variável a seguir
  printf("  <input type='hidden' name='sair' value='$sair'>\n");
  printf("<titulo>InstEnsinoNiveisEduc</titulo>:\n");
  printf("<button class='Incluir' type='submit' formaction='./instensinoniveiseducincluir.php'  >Incluir</button>"); # &#x1f7a5;
  printf("<button class='Alterar' type='submit' formaction='./instensinoniveiseducalterar.php'  >Alterar</button>"); # &#x1f589;
  printf("<button class='Excluir' type='submit' formaction='./instensinoniveiseducexcluir.php'  >Excluir</button>"); # &#x1f7ac;
  printf("<button class='Consultar' type='submit' formaction='./instensinoniveiseducconsultar.php'>Consultar</button>"); # &#x1f50d;&#xfe0e;
  printf("<button class='Listar' type='submit' formaction='./instensinoniveiseduclistar.php'   >Listar</button>"); # &#x1f5a8;
  # Em revisão em 2023-05-13 Inclui os botões de Salto para 'Abertura' e para 'Saída do Sistema'.
  # Estes botões foram retiradas da função botoes() - Analise o código-fonte da função.
  $menu=$sair-1;
  printf(($menu>0) ? "<input class='imp' type='button' value='Abertura' onclick='history.go(-$menu)'>" : "");
  # NOTE: No comando acima o botão 'Abertura' só será exibido depois que o usuário acessar a primeira tela de qualquer funcionalidade.
  printf("<input class='imp' type='button' value='Sair' onclick='history.go(-$sair)'>\n");
  printf(" </form>\n");
  printf("</div>\n");
  printf("<redbold>$acao</redbold><hr>\n");
  printf("</div>\n<br><br><br>\n");
}
# Esta função já revisada para 'rodar' nos seguintes navegadores: Firefox, Crhome e Edge.
# Esta função NÃO apresenta mais os botões 'Abertura' e 'Sair' que foram 'deslocados' para a barra de MENU.
function botoes($acao,$limpar,$voltar)
{ #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # Função.....: botoes
  # Objetivo...: Montar a barra de botoes das telas de cada funcionalidade.
  # Descricao..: Emite as TAGs que montam os botões de navegação no PA. Os botões de navegação pode ser omitidos (se o navegador permitir).
  # Parametros.: Esta Funcao recebe os parametros:
  #              $acao - Associado à ação de SUBMIT dos campos do formulário. O parâmetro recebe como argumento um texto com a ação (ICAEL).
  #              $limpar - Associado à ação de RESET dos campos do formulário. O parâmetro recebe o argumento TRUE | FALSE.
  #              $voltar - Executa a ação de history.go(-1). O parâmetro recebe o argumento TRUE | FALSE.
  #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # As tags serão montadas na variável $barra.
  $barra="";
  $barra=( $acao!="" ) ? $barra."   <input class='imp' type='submit' value='$acao'>" : "";
  $barra=(  $limpar  ) ? $barra."   <input class='imp' type='reset'  value='Limpar'>" : $barra ;
  $barra=(  $voltar  ) ? $barra."   <input class='imp' type='button' value='Voltar' onclick='history.go(-1)'>" : $barra ;
  printf("$barra\n");
}
?>