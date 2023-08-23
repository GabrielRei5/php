<?php
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Programa.: instensinoniveiseducconsultar.php
# Objetivo.: Gerenciar a funcionalidade 'Consultar'.
# Descricao: Programa recursivo. Executa dois arquivos externos (requere_once() para catalogo.php e instensinoniveiseducfuncoes.php). Inicia as variáveis de controle de
#            execucção recursiva e de navegação. Inicia a execução controlada. No 1º bloco executa a picklist. No 2º bloco executa a mostraregistro.
# Autor....: GRDS
# Criacao..: 2023-05-26
# 
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Referenciando o arquivo toolskit.php
require_once("../../funcoes/catalogo.php");
# Referenciando o arquivo instensinoniveiseducfuncoes.php
require_once("./instensinoniveiseducfuncoes.php");
iniciapagina(TRUE,"InstEnsinoNiveisEduc","instensinoniveiseduc","Consultar");
# Determinando variáveis de controle: $bloco $menu e $sair
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
# Executando função que monta o menu no topo da tela
montamenu("Consultar",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
#
# Com o comando a seguir se faz a execução seletiva dos blocos de comandos: montagem do form e controle da transação com base no valor de $bloco.
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;
switch (TRUE)
{
  case ($bloco==1):
  {
    picklist("Consultar");
    break;
  }
  case ( $bloco==2 ):
  { # Segundo bloco do programa.
    # Para o LST e CON é o trecho de leitura do BD e exibição dos dados
    mostraregistro("$_REQUEST[pkinstensinoniveiseduc]");
    botoes("",FALSE,TRUE); # Reescrito no arquivo de instensinoniveiseducfuncoes.php. Parâmetros: Ação | Limpar | Voltar
    break;
  }
}
terminapagina("instensinoniveiseduc","Consultar","instensinoniveiseducconsultar.php");
 ?>