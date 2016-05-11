<?php
/**
 * This file contains the XmlEncoder class.
 *
 * PHP Version 5.3
 *
 * @author  Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @license https://github.com/soloproyectos-php/xml-encoder/blob/master/LICENSE The MIT License (MIT)
 * @link    https://github.com/soloproyectos-php/xml-encoder
 */
namespace soloproyectos\xml\encoder;
use soloproyectos\arr\Arr;

/**
 * XmlEncoder class.
 * 
 * This class is a 'wrapper' of the functions htmlspecialchars and htmlspecialchars_decode.
 * See the following links for more info:
 * 
 * http://php.net/manual/en/function.htmlspecialchars.php
 * http://php.net/manual/en/function.htmlspecialchars-decode.php
 *
 * @package Dom\Node
 * @author  Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @license https://github.com/soloproyectos-php/xml-encoder/blob/master/LICENSE The MIT License (MIT)
 * @link    https://github.com/soloproyectos-php/xml-encoder
 */
class XmlEncoder
{
    /**
     * Flags.
     * @var integer
     */
    private $_flags = 0;
    
    /**
     * Encoding.
     * @var string
     */
    private $_encoding = "";
    
    /**
     * Is double encode?
     * @var boolean
     */
    private $_doubleEncode = true;
    
    /**
     * Constructor.
     * 
     * For more information about parameters see:
     * http://php.net/manual/en/function.htmlspecialchars.php
     * 
     * Parameters:
     * ```text
     * $options["flags"]   : Flags(not required, default is ENT_COMPAT | ENT_HTML401)
     * $options["encoding"]: Encoding (not required, default is ini_get("default_charset"))
     * $options["double_encode"]: Double encode (not required, default is true)
     * ```
     * 
     * Examples:
     * ```php
     * // the most simple way
     * $xml = new XmlEncoder();
     * echo $xml->encode("Rick & Morty");
     * 
     * // more elaborated way
     * $xml = new XmlEncoder([
     *      "flags" => ENT_QUOTES|ENT_XML1,
     *      "encoding" => "ISO-8859-1",
     *      "double_encode" => false
     * ]);
     * echo $xml->encode("Rick & Morty");
     * ```
     * 
     * @param array $options Options
     */
    public function __construct($options = [])
    {
        $this->_flags = Arr::get($options, "flags", ENT_COMPAT | ENT_HTML401);
        $this->_encoding = Arr::get($options, "encoding", ini_get("default_charset"));
        $this->_doubleEncode = Arr::get($options, "double_encode", true);
    }
    
    /**
     * Encodes a text.
     * 
     * @param string $text Text
     * 
     * @return string
     */
    public function encode($text)
    {
        return htmlspecialchars($text, $this->_flags, $this->_encoding, $this->_doubleEncode);
    }
    
    /**
     * Decodes a text.
     * 
     * @param string $text Text
     * 
     * @return string
     */
    public function decode($text)
    {
        return htmlspecialchars_decode($text, $this->_flags);
    }
    
    /**
     * Wraps a text around CDATA.
     * 
     * @param string $text Text
     * 
     * @return string
     */
    public function cdata($text)
    {
        $text = str_replace(array("<![", "]>"), array("&lt;![", "]&gt;"), $text);
        return "<![CDATA[$text]]>";
    }
}
