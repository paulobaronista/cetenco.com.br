<?php

// Este arquivo tem como finalidade testar a execução do php e exibir as configurações do arquivo php.ini 
// Para utiliza-lo recomenando que faça upload do mesmo em diretório criado e nomeado como testesuporte dentro do diretório de publicação
// Para acessar após o upload como especificado acima basta digitar dominiodesejado.com.br/testesuporte/info.php

phpinfo();

/*  PARA ESTUDO E MAIS DETALHES
Opções phpinfo()
Nome (constant)	Valor	Descrição
INFO_GENERAL	1	 A linha de configuração, localização do php.ini data de construção, Servidor Web, Sistema e mais.
INFO_CREDITS	2	 Créditos do PHP 4. Veja também phpcredits().
INFO_CONFIGURATION	4	 Valores locais e principais para as diretivas de configuração do PHP. Veja também ini_get().
INFO_MODULES	8	 Módulos carregados e suas respectivas configurações. Veja também get_loaded_modules().
INFO_ENVIRONMENT	16	 Informação das variáveis de ambiente que também esta disponível em $_ENV.
INFO_VARIABLES	32	 Mostra todas as variáveis pré-definidas de EGPCS (Environment, GET, POST, Cookie, Server).
INFO_LICENSE	64	 Informação sobre a Licença do PHP. Veja também o » faq sobre a licença.
INFO_ALL	-1	 Mostra tudo acima. Este é o valor padrão.


EXEMPLO DE UTILIZAÇÃO
Mostrar apenas diretivas do PHP
phpinfo(4);
*/

?>