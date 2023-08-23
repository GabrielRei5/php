<?php
ini_set('display_errors', 1);
function iniciapagina($fundo,$tittab,$tabela,$acao)
{ #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # Função.....: iniciapagina
  # Descricao..: Emite as TAGs de inicio de página HTML
  # Parâmetros.: Esta Funcao recebe os parametros:
  #              $fundo.: Booleano (TRUE|FALSE) indicando se a cor de fundo da tela deve ou não ser exibida.
  #              $tittab: Texto com o nome da tabela (Com a 1ª Letra em maiúscula e com acentos corretos).
  #              $tabela: Texto com o nome da tabela como está escrito na base de dados. Este parâmetro é usado para formar o nome do arquivo .CSS
  #              $acao..: Texto com o Título da Ação que executa a função (Incluir, Consultar, Excluir, Alterar ou Listar).
  # Autor......: ACRP
  # Criação....: 2023-05-25
  # 
  #------------------------------------------------------------------------------------------------------------------------------------------------------------
  printf("<html>\n");
  printf(" <head>\n");
  printf("  <title>$tabela-$acao</title>\n");
  printf("  <link rel='stylesheet' href='./$tabela.css'>\n");
  printf(" </head>\n");
  printf($fundo ? " <body class='$acao'>\n" : " <body>\n");
}
function terminapagina($tabela,$acao,$prg)
{ #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # Função.....: terminapagina
  # Descricao..: Esta funcao emite as TAGs finais da página HTML (barra de 'status' com indicação do programa, tabela e ação executada.
  # Parâmetros.: Esta Funcao recebe os parametros:
  #              $tabela: Texto que aparece no botao SUBMIT.
  #              $acao..: Texto com a ação feita no PA (Incluir, Consultar, Excluir, Alterar, Listar e Abertura).
  #              $prg...: Nome do Arquivo que tem o PA.
  #------------------------------------------------------------------------------------------------------------------------------------------------------------
  printf(" <hr>$tabela %s | &copy; ".date('Y')." - ACRP+FATEC-4ºADS | $prg",$acao? " - ".$acao : "");
  printf("</div>\n");
  printf(" </body>\n");
  printf("</html>");
}
function conectamariadb($server,$username,$senha,$dbname)
{ #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # função.....: conexão com bancos de dados do gerenciador MariaDB.
  # A PHP dispõe de FUNÇÕES de AMBIENTE para tratar aspectos de programa, tais como processamento de dados em BD (externos).
  # Para 'acessar' um BD (cuidado por um SGBD), a PHP usa um conjunto de funções.
  # Para o SGBD MySQL (ou MariaDB) o conjunto de funções são identificados por mysqli_.
  # o retorno da função de ambiente que faz a conexão de um PA com o SGBD é um NÚMERO.
  # o número da conexão pode ser aramazenado em variável PHP.
  # a sintaxe da função de conexão indica que a função recebe 4 parâmetros:
  # $server..: Nome do servidor
  # $username: Nome do usuário
  # $senha...: Senha de acesso do usuario ao sgbd
  # $dbname.: Nome da base de dados.
  #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # globalizando uma variavel de conexão
  global $link;
  # Determinando a conexão
  $link=mysqli_connect($server,$username,$senha,$dbname);
}
# Terminado o segmento de funções (que podem ser executadas por qualquer aplicativo que acesse o toolskit.php),
#----------------------------------------------------------------------------------------------------------------------------------------------------
# Aqui começa o 'Bloco Principal' deste PA-PHP
# executando a função de conexão com o SGBD MariaDB.
conectamariadb("localhost","root","v1a9","ilp540");
# Com a execução da função de conexão 'dentro' deste arquivo... ao executar o require_once() em um PA o Programa já 'recebe' a conexão com a
# base de dados, sem que o programador precise fazer a conexão. Isso pode ser prático em situações onde todos os PA acessam a base de dados no
# mesmo 'usuario do banco de dados'.
?>