<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */

namespace Melp\Term;

use Melp\Term\Ansi\Cursor;

class Term {
    public static function esc($seq) {
        $args = func_get_args();
        return "\033[" . vsprintf(array_shift($args), $args);
    }


    function __construct($stream = STDOUT) {
        $this->stream = $stream;
    }


    function csave() {
        return $this(self::esc(Cursor::SAVE));
    }


    function crestore() {
        return $this(self::esc(Cursor::RESTORE));
    }


    function cmv($x, $y) {
        return $this(self::esc(Cursor::MOVE, $x, $y));
    }


    function cup($n = 1) {
        return $this(self::esc(Cursor::UP, $n));
    }


    function cdown($n = 1) {
        return $this(self::esc(Cursor::DOWN, $n));
    }


    function cleft($n = 1) {
        return $this(self::esc(Cursor::BWD, $n));
    }


    function cright($n = 1) {
        return $this(self::esc(Cursor::FWD, $n));
    }


    function clear() {
        return $this(self::esc(Cursor::CLEAR));
    }


    function clearln() {
        return $this(self::esc(Cursor::CLEARLN));
    }


    function clearleft() {
        return $this(self::esc(Cursor::CLEARLEFT));
    }


    function chide() {
        return $this(self::esc(Cursor::HIDE));
    }

    function cshow() {
        return $this(self::esc(Cursor::SHOW));
    }


    function write($str) {
        return $this($str);
    }


    function size() {
        return array(
            $this->width(),
            $this->height()
        );
    }

    public function height()
    {
        return exec('tput lines');
    }

    public function width()
    {
        return exec('tput cols');
    }

    /**
     * @param $s
     * @return Term
     */
    function __invoke($s) {
        if (is_callable($s)) {
            $s($this);
        } else {
            fwrite($this->stream, $s);
        }
        return $this;
    }
}