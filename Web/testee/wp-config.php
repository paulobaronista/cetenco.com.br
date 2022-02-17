<?php
/** 
* As configurações básicas do WordPress.
*
* Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
* Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
* visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
* wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
*
* Esse arquivo é usado pelo script ed criação wp-config.php durante a
* instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
* como "wp-config.php" e preencher os valores.
*
* @package WordPress
*/
// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/storage/9/27/80/uniduni1/public_html/site/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'uniduni13');
/** Usuário do banco de dados MySQL */
define('DB_USER', 'uniduni13');
/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'a1b2c3d4e5');
/** nome do host do MySQL */
define('DB_HOST', 'mysql04.unidunite.net');
/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');
/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');
define('WP_MEMORY_LIMIT', '1024M');
/**#@+
* Chaves únicas de autenticação e salts.
*
* Altere cada chave para um frase única!
* Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
* Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
*
* @since 2.6.0
*/
define('AUTH_KEY',         'F2E!O7`0(ne@_ETw-0:$8LNziXf!&u.0bJ/!<fF[T^2ai.O4izOunK@G0@RCmv--');
define('SECURE_AUTH_KEY',  '{sDwN/eyre=qpWE:2QX*{N!x@`=&c-^y}qGS{9/#N)9znAy7Uk=Ob}Dq+Yr!C:pm');
define('LOGGED_IN_KEY',    'yIA9~S|32-DMF;eWEdi<6x)w]^i|LsX`)qp$99| < ,?Gu}|KRFRO9Yo9,Bt(g*@');
define('NONCE_KEY',        'V~j*V&m1;[Y-OOnd:}ffS7a@v1`Yr?)pZj*/-T+.b+l[.$4wHg/y0dOCo0an_?SS');
define('AUTH_SALT',        'r3q&#?*.QbJ+{|7H|>dwLC~!l44f)Uq+!j%tBo/|r}GtK||;$!Jd6+[mY+5wWtjD');
define('SECURE_AUTH_SALT', 'O/Nl2$djb&V$|(~rvK2:k6!kkbKDQU`Jb+Tzk>k-+(G}@LPoa?zn#J7A6x`f+q#|');
define('LOGGED_IN_SALT',   '9$]D;BfQtJJN[j L=Ms;vXJ-B^Ixt6icNy?]MiEtav9&J~Zf|[]1zAhs<zA9sRRy');
define('NONCE_SALT',       'b2+:W.UdA>d0?.QT|2:h8xV*3*+6%o~>(&zIU|/Zq0VD>[h0dz)QF+b_Wr8ApcQd');
/**#@-*/
/**
* Prefixo da tabela do banco de dados do WordPress.
*
* Você pode ter várias instalações em um único banco de dados se você der para cada um um único
* prefixo. Somente números, letras e sublinhados!
*/
$table_prefix  = 'str_';
/**
* O idioma localizado do WordPress é o inglês por padrão.
*
* Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
* idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
* pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
* ao português do Brasil.
*/
define('WPLANG', 'pt_BR');
/**
* Para desenvolvedores: Modo debugging WordPress.
*
* altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
* é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
* em seus ambientes de desenvolvimento.
*/
define('WP_DEBUG', false);
/* Isto é tudo, pode parar de editar! :) */
/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
