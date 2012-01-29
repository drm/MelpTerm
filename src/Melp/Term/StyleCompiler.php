<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */
namespace Melp\Term;

use Melp\Term\Ansi\Style as C;

class StyleCompiler {
    protected $stack;
    public $reset = "\033[0m";

    function __construct() {
        $this->tags = array(
            'b'         => new Style(null, null, array(C::BOLD)),
            'dim'       => new Style(null, null, array(C::DIM)),
            'red'       => new Style(C::RED),
            'green'     => new Style(C::GREEN),
            'regular'   => new Style(null, null, array(C::NOBOLD, C::NODIM, C::NOUNDERLINE, C::NOBLINK, C::NOINVERSE)),

            'default'   => new Style(C::DEFAULT_, C::BDEFAULT, array(C::NOBOLD, C::NODIM, C::NOUNDERLINE, C::NOBLINK, C::NOINVERSE)),
            'inv'       => new Style(null, null, array(C::INVERSE))
        );
    }


    function compile($data, $resultStream = null) {
        while(strlen($data)) {
            $m = null;
            // scan for tags
            while (strlen($data) && !($data[0] == '<' && preg_match('!<([^>]+)>!A', $data, $m))) {
                fwrite($resultStream, $data[0]);
                $data = substr($data, 1);
            }
            // if no match, we reached EOF
            if (!$m) {
                return;
            }
            $tagName = $m[1];

            if ($tagName[0] == '/') {
                $tagName = substr($tagName, 1);
                if (empty($this->stack) || !isset($this->tags[$tagName])) {
                    // ignore if not opened, or not a known tag.
                    fwrite($resultStream, $m[0]);
                } else {
                    $tail = array_pop($this->stack);
                    if ($tagName != $tail) {
                        throw new ParseError("Mismatched closing tag $tagName, expected $tail");
                    }
                }
                // even though this isn't the most efficient way as opposed to calculating an aggregate of the stack,
                // it is probably more efficient to have the terminal figure that out.
                fwrite($resultStream, $this->reset);
                foreach ($this->stack as $type) {
                    fwrite($resultStream, $this->tags[$type]);
                }
            } elseif (isset($this->tags[$tagName])) {
                $this->stack[]= $tagName;
                fwrite($resultStream, $this->tags[$m[1]]);
            } else {
                fwrite($resultStream, $m[0]);
            }
            $data = substr($data, strlen($m[0]));
        }
    }


    function format($str) {
        $resultStream = fopen('php://memory', 'rw');
        $this->compile($str, $resultStream);
        rewind($resultStream);
        return stream_get_contents($resultStream);
    }
}
