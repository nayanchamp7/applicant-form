<?php
/**
 * Autoload Class
 *
 * @category Autoload
 * @package  Autoload
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

/**
 * Autoload class
 *
 * @class Autoload The class that autoload all the expected files
 *
 * @category Autoload
 * @package  Autoload
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @property null|object $_instance Instance of the class
 */
class Autoload
{

    /**
     * Instance
     *
     * @access private
     * @var    object Class Instance.
     * @since  1.0.0
     */
    private static $_instance;

    /**
     * Initiator
     *
     * @since  1.0.0
     * @return object initialized object of class.
     */
    public static function get_instance()
    {
        if (! isset(self::$_instance) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Autoload classes.
     *
     * @param string $class class name.
     * 
     * @return void
     */
    public function autoload( $class )
    {
        if (0 !== strpos($class, __NAMESPACE__) ) {
            return;
        }
        $class_to_load = $class;
        
        $filename = strtolower(
            preg_replace(
                [ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                [ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
                $class_to_load
            )
        );

        $file = AFM_FILE_DIR . '/includes/class-' . $filename . '.php';

        // if the file redable, include it.
        if (is_readable($file) ) {
            include_once $file;
        }
    }
}

Autoload::get_instance();
