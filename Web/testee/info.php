<?php

// Este arquivo tem como finalidade testar a execu��o do php e exibir as configura��es do arquivo php.ini 
// Para utiliza-lo recomenando que fa�a upload do mesmo em diret�rio criado e nomeado como testesuporte dentro do diret�rio de publica��o
// Para acessar ap�s o upload como especificado acima basta digitar dominiodesejado.com.br/testesuporte/info.php

phpinfo();

/*  PARA ESTUDO E MAIS DETALHES
Op��es phpinfo()
Nome (constant)	Valor	Descri��o
INFO_GENERAL	1	 A linha de configura��o, localiza��o do php.ini data de constru��o, Servidor Web, Sistema e mais.
INFO_CREDITS	2	 Cr�ditos do PHP 4. Veja tamb�m phpcredits().
INFO_CONFIGURATION	4	 Valores locais e principais para as diretivas de configura��o do PHP. Veja tamb�m ini_get().
INFO_MODULES	8	 M�dulos carregados e suas respectivas configura��es. Veja tamb�m get_loaded_modules().
INFO_ENVIRONMENT	16	 Informa��o das vari�veis de ambiente que tamb�m esta dispon�vel em $_ENV.
INFO_VARIABLES	32	 Mostra todas as vari�veis pr�-definidas de EGPCS (Environment, GET, POST, Cookie, Server).
INFO_LICENSE	64	 Informa��o sobre a Licen�a do PHP. Veja tamb�m o � faq sobre a licen�a.
INFO_ALL	-1	 Mostra tudo acima. Este � o valor padr�o.


EXEMPLO DE UTILIZA��O
Mostrar apenas diretivas do PHP
phpinfo(4);
*/

?>