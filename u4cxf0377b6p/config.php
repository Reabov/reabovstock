<?
$env = parse_ini_file('.env');

/* используется при создании хэша пароля */
$GLOBALS['security_salt'] = '1Fe403GcWLuyf7zH'; // указать длину от 15 символов // https://www.lastpass.com/password-generator
if( $GLOBALS['security_salt'] == '' || strlen( $GLOBALS['security_salt'] ) < 15 ) {
    exit( 'error code: 800' );
}

$GLOBALS['project_name'] = 'Reabov Studio'; // Указывать название проекта, виден в админ панели
if( $GLOBALS['project_name'] == '' ) {
    exit( 'error code: 804' );
}
/* режим работы dev | public; влияет на вывод ошибок, частоту формирования бэкапа бд */
//$GLOBALS['mode'] = 'public';

/* окончание урл-ов - со слэшем или нет */
$GLOBALS['last_slash'] = true;

/* Unblocking Key */
// $GLOBALS['uk'] = '1n8dm1hZ90bFuTBb';

/* Protocol */
$GLOBALS['protocol'] = stripos( $_SERVER['SERVER_PROTOCOL'] , 'https' ) === true ? 'https://' : 'http://';

/* Default timezone */
$GLOBALS['timezone'] = 'Europe/Chisinau';

/* доступы к БД */
$SERVER_NAME    = $env['SERVER_NAME'];
$DB_LOGIN       = $env['DB_LOGIN'];
$DB_PASS        = $env['DB_PASS'];
$DB_NAME        = $env['DB_NAME'];
$DB_PORT        = $env['DB_PORT'];

// используется в созданий авто бэкапов и в ручную из админке
// $dateName = date("Y-m-d-H");
/*
switch ( $GLOBALS['mode'] ) {
	case 'dev':
		error_reporting( E_ALL );
		break;
	
	case 'public':
		error_reporting( 0 );
		break;
	
	default:
		error_reporting( E_ERROR );
		break;
}*/

