<?php
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# Programa.: instensinoniveiseduc (instensinoniveiseduc.php)
# Objetivo.: Desenvolver a funcionalidade "Abertura" do Sistema de Gerenciamento de Dados na Tabela (instensinoniveiseduc) Referenciada para estudo.
# Descrição: Inclui a execução dos arquivos externos (require para "../../funcoes/catalogo1.php" e "./instensinoniveiseducfuncoes.php"), identifica valor de variável
#            de controle de saltos entre aplicativos ($sair) e de retorno para 'Abertura' do sistema. Executa funções externas e exibe mensagem de orientação
#             do uso do sistema. Este programa não é recursivo.
# Autor....: GRDS
# Criação..: 2023-05-26
# 
#--------------------------------------------------------------------------------------------------------------------------------------------------------------
# estrutura de diretórios onde se posicionam os arquivos dos PA
# localhost/funcoes/ - arquivo de funções (toolsbag.php)
#          /fontes/NomeTab/ - Arquivos dos PAs e o arquivo .css configurando os elementos da página do SI de Gerenciamento de Dados.
# O NomeTab deve ser o nome da tabela como está escrito na base de dados do exercício PRATICASQL.
require_once("../../funcoes/catalogo.php");
# Referenciando o arquivo instensinoniveiseducfuncoes.php
require_once("./instensinoniveiseducfuncoes.php");
# Determinando o valor de $sair. NOTE: é neste comando do sistema que se inicia a variável $sair que é referenciada na função montamenu() para montar a navegação interna do sistema.
# Por este motivo é que este PA tem que ser executado SEMPRE (para se montar de modo correto o sistema de navegação interna dos aplicativos.
$sair=( ISSET($_REQUEST['sair']) ) ? $_REQUEST['sair'] : 1;
$menu=$sair-1;
# monstrando o valor de $sair em cada execução
# printf("$sair<br>\n");
iniciapagina(TRUE,"InstEnsinoNiveisEduc","instensinoniveiseduc","Abertura");
montamenu("Abertura",$sair);
printf("<p>\n");
printf("Este sistema faz o Gerenciamento de dados da Tabela instensinoniveiseduc.<br>\n");
printf("O menu apresentado acima indica as funcionalidades do sistema.<br><br>\n");
printf("Este sistema deve permitir a navegação usando botões e acessos configurados<br>\n");
printf("como texto (sem bordas, com fundo transparente e texto no mesmo formato<br>\n");
printf("do ambiente onde o elemento está sendo exibido).<br>\n");
printf("Esta página (foi designada como <red>ABERTURA</red>)<br>\n");
printf("Em cada funcionalidade acessada pelo usuário do sistema devem estar disponíveis<br>\n");
printf("botões e acessos de navegação permitindo:<br>\n");
printf("Abertura - Saltar para a página de abertura<br>\n");
printf("Sair - Saltar para fora do sistema<br>\n");
printf("Voltar - Pular <em>UMA</em> página para trás na lista de páginas acessadas<br>\n");
printf("Salvar - Confirmar a ação de uma funcionalidade acessada.<br>\n");
printf("Limpar - Limpar os dados dos campos de formulários (resetar)<br><br>\n");
printf("Em TODAS as telas deve-se ver o menu na parte superior e a linha de rodapé configurada como abaixo.<br>\n");
printf("Nome: Gabriel Reis Dos Santos <br>Matricula: 0210482122004<br>\n");
printf("</p>\n");
terminapagina("instensinoniveiseduc","Abertura","instensinoniveiseduc.php");
?>