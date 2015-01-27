<?php
namespace Translate;
use Phalcon\Exception;
use \Phalcon\Translate\Adapter\NativeArray as TranslateAdapter;

/**
 * Translate service class
 *
 * @package   Plugins
 * @subpackage   Plugins\Translate
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Translate extends TranslateAdapter {

    /**
     * Translate directory path
     *
     * @access private
     * @var string
     */
    private $path = '';

    /**
     * Preferred or selected language
     *
     * @access private
     * @var string
     */
    private $language = '';

    /**
     * Required lang files
     *
     * @access private
     * @var array
     */
    private $required = [];

    /**
     * Define an empty constructor. To extend of parent
     */
    public function __construct() {}

    /**
     * Setup translate path
     *
     * @param string $path
     * @return Translate
     */
    public function setTranslatePath($path) {
        $this->path =   $path;

        return $this;
    }

    /**
     * Set preferred or selected language
     * @param string $language
     * @return Translate
     */
    public function setLanguage($language) {
        $this->language =   $language;

        return $this;
    }

    /**
     * Get content from loaded translate file
     *
     * @param string $signature
     * @return void
     */
    public function get($signature) {

        $file = $this->path.$this->language.DIRECTORY_SEPARATOR.$signature.'.php';
        if(!isset($this->required[$file])) {

            if (file_exists($file)) {

                $content = require_once $file;
                $this->required[$file] = true;
                parent::__construct(['content' => $content]);

            }
        }
        else {
            throw new Exception('Could not find translate file: '.$file);
        }
    }
}