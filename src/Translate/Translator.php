<?php
namespace Translate;
use Phalcon\Exception;
use Phalcon\Translate\Adapter\NativeArray as TranslateAdapterArray;

/**
 * Translate service class
 *
 * @package   Translate
 * @subpackage   Translate\Translator
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Translator
{

    /**
     * Translate directory path
     *
     * @access private
     * @var string
     */
    private $path = '';

    /**
     * Default language
     *
     * @access private
     * @var string
     */
    private $default = 'en';

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
     * Translate adapter
     *
     * @var \Phalcon\Translate\Adapter\NativeArray $adapter
     */
    private $adapter;

    /**
     * Adapter signature
     *
     * @var array
     * @access private
     */
    private $signature  = [];

    /**
     * Setup translate path
     *
     * @param string $path
     * @return Translator
     */
    public function setTranslatePath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Set preferred or selected language
     *
     * @param string $language
     * @return Translator
     */
    public function setLanguage($language) {
        $this->language = $language;

        return $this;
    }
    
    /**
     * Assign content to loaded translate file
     *
     * @param string $signature
     * @throws Exception
     * @return Translator|null
     */
    public function assign($signature) {

        $file = $this->path.$this->language.DIRECTORY_SEPARATOR.$signature.'.php';

        // content does not loaded yet
        if(isset($this->required[$file]) === false) {

            if (file_exists($file) === true) {

                $content = include $file;
                $this->required[$file] = true;
            }

            // assign to translate
            $this->adapter = new TranslateAdapterArray(['content' => [
                    $signature => $content
            ]]);
        }

        // setup signature
        $this->signature = $this->adapter->offsetGet($signature);

        return $this;
    }

    /**
     * Setup default language
     *
     * @param string $default
     * @return Translator
     */
    public function setDefault($default) {
        $this->default = $default;

        return $this;
    }

    /**
     * Translate original string
     *
     * @param $string
     * @throws Exception
     * @return string
     */
    public function translate($string) {

        // get selected signature

        if(empty($this->signature) === false) {
            if (array_key_exists($string, $this->signature) === false) {
                return $string;
            }
            return $this->signature[$string];
        }
        else {
            throw new Exception('Could not find translate signature');
        }
    }
}
