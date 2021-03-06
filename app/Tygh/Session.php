<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

namespace Tygh;

use Tygh\Bootstrap;
use Tygh\Storage;
use Tygh\Tools\SecurityHelper;

class Session
{
    private static $_session;
    private static $_name;

    protected static $ttl_online = SESSION_ONLINE;
    protected static $ttl_storage = SESSIONS_STORAGE_ALIVE_TIME;
    protected static $ttl = SESSION_ALIVE_TIME;

    /**
     * Generate session ID for different area
     *
     * @param string $sess_id session ID from cookie
     * @param string $area    session area
     *
     * @return string modified session ID
     */
    private static function _sid($sess_id, $area = AREA)
    {
        fn_set_hook('sid', $sess_id);

        return $sess_id . '_' . $area;
    }

    /**
     * Generates session id
     *
     * @return string new session ID
     */
    private static function _generateId()
    {
        return SecurityHelper::generateRandomString();
    }

    /**
     * Checks if session needs to be started
     * @return boolean true if session should be started, false - otherwise
     */
    private static function canStart()
    {
        return !defined('NO_SESSION') || defined('FORCE_SESSION_START');
    }

    /**
     * Checks if session needs to be validated
     * @return boolean true if session should be validated, false - otherwise
     */
    private static function needValidate()
    {
        return (defined('SESS_VALIDATE_IP') || defined('SESS_VALIDATE_UA')) && !defined('FORCE_SESSION_START');
    }

    /**
     * Start session (default action)
     *
     * @param string $save_path path for session storage
     * @param array  $sess_name session name
     */
    public static function open($save_path, $sess_name)
    {
        return true;
    }

    /**
     * Close session (default action)
     *
     * @return boolean always true
     */
    public static function close()
    {
        return true;
    }

    /**
     * Read session from session storage (default action)
     *
     * @param string $sess_id session ID
     *
     * @return array session data
     */
    public static function read($sess_id)
    {
        $data = self::$_session->read($sess_id);
        if ($data === false) {
            $stored_data = db_get_field('SELECT data FROM ?:stored_sessions WHERE session_id = ?s', $sess_id);

            if (!empty($stored_data)) {

                db_query('DELETE FROM ?:stored_sessions WHERE session_id = ?s', $sess_id);

                $current = array();
                $_stored = self::decode($stored_data);
                $_current['settings'] = !empty($_stored['settings']) ? $_stored['settings'] : array();

                $data = self::encode($_current);
            }
        }

        return $data;
    }

    /**
     * Write session to session storage (default action)
     *
     * @param string $sess_id session ID
     * @param array  $data    session data
     *
     * @return boolean true if saved, false otherwise
     */
    public static function write($sess_id, $data)
    {
        return self::save($sess_id, $data);
    }

    /**
     * Save session to storage
     *
     * @param string $sess_id session ID
     * @param array  $data    session data
     * @param string $area    session area
     *
     * @return boolean true if saved, false otherwise
     */
    public static function save($sess_id, $data, $area = AREA)
    {
        if (empty(self::$_session)) {
            return false;
        }

        // if used not by standard session handler, can accept data in array, not in serialized array
        if (is_array($data)) {
            $data = self::encode($data);
        }

        $_data = array(
            'expiry' => TIME + self::$ttl,
            'data' => $data
        );

        return self::$_session->write($sess_id, $_data);
    }

    /**
     * Session serializer
     *
     * @param array $data session data
     *
     * @return string serialized data
     */
    public static function encode($data)
    {

        $raw = '' ;
        $line = 0 ;
        $keys = array_keys($data) ;

        foreach ($keys as $key) {
            $value = $data[$key] ;
            $line++;

            $raw .= $key . '|' . serialize($value);

        }

        return $raw ;

    }

    /**
     * Session unserializer
     *
     * @param string $string serialized session data
     *
     * @return array unserialized session data
     */
    public static function decode($string)
    {
        $data = array ();

        if (!empty($string)) {
            $vars = preg_split('/([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff^|]*)\|/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            for ($i = 0; !empty($vars[$i]); $i++) {
                $data[$vars[$i++]] = unserialize($vars[$i]);
            }
        }

        return $data;
    }

    /**
     * Destroy session (default action)
     *
     * @param string $sess_id session ID
     *
     * @return boolean true if destroyed, false otherwise
     */
    public static function destroy($sess_id)
    {
        return self::$_session->delete($sess_id);
    }

    /**
     * Garbage collector (default action)
     *
     * @param int $max_lifetime session life time
     *
     * @return boolean always true
     */
    public static function gc($max_lifetime)
    {
        self::$_session->gc($max_lifetime);

        // Cleanup stored sessions
        db_query('DELETE FROM ?:stored_sessions WHERE expiry < ?i', TIME - Registry::get('config.ttl_storage'));

        // Delete custom files (garbage) from unlogged customers
        $files = Storage::instance('custom_files')->getList('sess_data');

        if (!empty($files)) {
            foreach ($files as $file) {
                $fdate = fileatime(Storage::instance('custom_files')->getAbsolutePath('sess_data/' . $file));

                if ($fdate < (TIME - self::$ttl_storage)) {
                    Storage::instance('custom_files')->delete('sess_data/' . $file);
                }
            }
        }

        return true;
    }

    /**
     * Get session variable name (default action)
     *
     * @return string session name
     */
    public static function getName()
    {
        return session_name();
    }

    /**
     * Get session ID (default action)
     *
     * @return string session ID
     */
    public static function getId()
    {
        return session_id();
    }

    /**
     * Set session ID
     *
     * @param string $sess_id      session ID
     * @param bool   $need_postfix Determines whether it is necessary to add company_id and area code to the end of the session_id value
     *
     * @return string new session ID
     */
    public static function setId($sess_id, $need_postfix = true)
    {
        return ($need_postfix) ? session_id(self::_sid($sess_id)) : session_id($sess_id);
    }

    /**
     * Regenerates session ID
     *
     * @return string new session ID
     */
    public static function regenerateId()
    {
        $old_id = self::getId();
        $new_id = self::_sid(self::_generateId());

        session_write_close();

        self::$_session->regenerate($old_id, $new_id);

        /**
         * Actions after regenerate session id
         *
         * @param string $old_id Old session Id
         * @param string $new_id New session Id
         */
        fn_set_hook('session_regenerate_id', $old_id, $new_id);

        self::setId($new_id, false);
        $_COOKIE[self::$_name] = $new_id; // put new session to COOKIE to pass validation if start method
        self::start();

        // Update linked data
        db_query('UPDATE ?:stored_sessions SET session_id = ?s WHERE session_id = ?s', $new_id, $old_id);
        db_query('UPDATE ?:user_session_products SET session_id = ?s WHERE session_id = ?s', $new_id, $old_id);

        return $new_id;
    }

    /**
     * Re-create session, returns new session ID
     *
     * @param string $sess_id session ID to start with
     *
     * @return string new session ID
     */
    public static function resetId($sess_id = null)
    {
        if ($sess_id == self::getId()) {
            return $sess_id;
        }

        session_destroy();
        // session_destroy kills our handlers,
        // http://bugs.php.net/bug.php?id=32330
        // so we set them again
        self::setHandlers();
        if (!empty($sess_id)) {
            self::setId($sess_id, false);
            $_COOKIE[self::$_name] = $sess_id;
        }

        self::start();

        return self::getId();
    }

    /**
     * Set session handlers
     */
    public static function setHandlers()
    {
        session_set_save_handler(
            array('\\Tygh\\Session', 'open'),
            array('\\Tygh\\Session', 'close'),
            array('\\Tygh\\Session', 'read'),
            array('\\Tygh\\Session', 'write'),
            array('\\Tygh\\Session', 'destroy'),
            array('\\Tygh\\Session', 'gc')
        );
    }

    /**
     * Starts session
     * @param array $request Request data
     */
    public static function start($request = array())
    {
        // Force transfer session id to cookies if it passed via url
        if (!empty($request[self::$_name])) {
            self::setId($request[self::$_name], false);
        } elseif (empty($_COOKIE[self::$_name])) {
            self::setId(self::_generateId());
        }

        session_name(self::$_name);
        session_start();

        // Session checker (for external services, returns "OK" if session exists, empty - otherwise)
        if (!empty($request['check_session'])) {
            die(!empty($_SESSION) ? 'OK' : '');
        }

        // Validate session
        if (self::needValidate()) {
            $validator_data = self::getValidatorData();
            if (!isset($_SESSION['_validator_data'])) {
                $_SESSION['_validator_data'] = $validator_data;
            } else {
                if ($_SESSION['_validator_data'] != $validator_data) {
                    session_regenerate_id();
                    $_SESSION = array();
                }
            }
        }

        // _SESSION superglobal variable populates here, so remove it from global scope if needed
        if (Bootstrap::getIniParam('register_globals')) {
            Bootstrap::unregisterGlobals('_SESSION');
        }

    }

    /**
     * Set session params
     */
    public static function setParams()
    {
        $host = defined('HTTPS')
            ? 'https://' . Registry::get('config.https_host')
            : 'http://' . Registry::get('config.http_host');

        $host = parse_url($host, PHP_URL_HOST);

        if (strpos($host, '.') !== false) {
            // Check if host has www, www2, www4 prefix and remove it
            $host = preg_replace('/^www[0-9]*\./i', '', $host);
            $host = strpos($host, '.') === 0 ? $host : '.' . $host;
        } else {
            // For local hosts set this to empty value
            $host = '';
        }

        ini_set('session.cookie_lifetime', self::$ttl_storage);
        $cookie_domain = '';
        if (!preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $host, $matches)) {
            $cookie_domain = $host;
            ini_set('session.cookie_domain', $cookie_domain);
        }
        $current_path = Registry::get('config.current_path');
        $cookie_path = !empty($current_path) ? $current_path : '/';
        ini_set('session.cookie_path', $cookie_path);
        ini_set('session.gc_probability', 1);
        ini_set('session.gc_divisor', 10); // probability is 10% that garbage collector starts
        ini_set('session.hash_function', '0'); // use md5 128bits
        ini_set('session.hash_bits_per_character', 4); // 4 bits for character, so we'll have 128/4 = 32 bytes hash length

        // Secure session cookie with HTTPONLY parameter
        session_set_cookie_params(self::$ttl_storage, $cookie_path, $cookie_domain, false, true);
    }

    /**
     * Get session validation data
     *
     * @return array validation data
     */
    public static function getValidatorData()
    {
        $data = array();

        if (defined('SESS_VALIDATE_IP')) {
            $ip = fn_get_ip();
            $data['ip'] = $ip['host'];
        }

        if (defined('SESS_VALIDATE_UA')) {
            $data['ua'] = md5($_SERVER['HTTP_USER_AGENT']);
        }

        return $data;
    }

    /**
     * Set session name
     *
     * @param $account_type - current account type
     * @return boolean always true
     */
    public static function setName($account_type = ACCOUNT_TYPE)
    {
        $sess_postfix = Registry::get('config.http_location');

        /**
         * Actions before setting session name
         *
         * @param string $account_type Current account type
         * @param string $sess_postfix Session postfix
         */
        fn_set_hook('session_set_name_before', $account_type, $sess_postfix);

        self::$_name = 'sid_' . $account_type . '_' . substr(md5($sess_postfix), 0, 5);

        return true;
    }

    /**
     * Init session
     *
     * @return boolean true if session was init correctly, false otherwise
     */
    public static function init($request)
    {
        if (!empty($request['no_session']) || defined('CONSOLE')) {
            fn_define('NO_SESSION', true);
        }

        if (self::canStart()) {
            self::setName();
            self::setParams();
            self::setHandlers();

            if (empty(self::$_session)) {
                $_session_class = Registry::ifGet('config.session_backend', 'database');
                $_session_class = '\\Tygh\\Backend\\Session\\' . ucfirst($_session_class);
                self::$_session = new $_session_class(Registry::get('config'), array(
                    'ttl' => self::$ttl,
                    'ttl_storage' => self::$ttl_storage,
                    'ttl_online' => self::$ttl_online
                ));
            }

            if (!empty(self::$_session)) {
                self::start($request);
                register_shutdown_function(array('\\Tygh\\Session', 'shutdown'));

                return true;
            }
        }

        return false;
    }

    /**
     * Gets online sessions
     * @param  string $area session area
     * @return array  list of session IDs
     */
    public static function getOnline($area = AREA)
    {
        return self::$_session->getOnline($area);
    }

    /**
     * Calls session save handler
     */
    public static function shutdown()
    {
        // we don't need to register shutdown function if it is ajax request,
        // because ajax request session manipulations are done in ob_handler.
        // ajax ob_handlers are lauched AFTER session_close so all session changes by ajax
        // will be unsaved.
        // so we call session_write_close() directly in our ajax ob_handler
        if (!defined('AJAX_REQUEST')) {
            session_write_close();
        }
    }

    /**
     * Expire session, move it to stored sessions and log out user
     * @param string $sess_id session ID
     * @param array  $session session data
     */
    public static function expire($sess_id, $session)
    {
        $sess_data = Session::decode($session['data']);

        db_query('REPLACE INTO ?:stored_sessions ?e', array(
            'session_id' => $sess_id,
            'data' => self::encode(array('settings' => $sess_data['settings'])),
            'expiry' => $session['expiry']
        ));

        if (!empty($sess_data['auth'])) {
            fn_log_user_logout($sess_data['auth'], $session['expiry']);
        }
    }
}
