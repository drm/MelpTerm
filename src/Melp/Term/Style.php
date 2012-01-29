<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */
namespace Melp\Term;

use Melp\Term\Ansi\Style as C;

class Style {
    public static $ESC = "\033[%sm";

    public static $COLORS = array(
        C::BLACK, C::RED, C::GREEN, C::YELLOW, C::BLUE, C::MAGENTA, C::CYAN, C::WHITE, C::DEFAULT_
    );

    public static $BGCOLORS = array(
        C::BBLACK, C::BRED, C::BGREEN, C::BYELLOW, C::BBLUE, C::BMAGENTA, C::BCYAN, C::BWHITE, C::BDEFAULT
    );

    public static $ATTRIBUTES = array(
        C::BOLD, C::DIM, C::UNDERLINE, C::BLINK, C::INVERSE, C::HIDE, C::STRIKE,
        C::NOBOLD, C::NODIM, C::NOUNDERLINE, C::NOBLINK, C::NOINVERSE, C::NOSTRIKE
    );


    public $color = null;
    public $bgcolor = null;
    public $attributes = array();

    function __construct($color = null, $bgcolor = null, array $attr = array()) {
        $this->color($color)->bgcolor($bgcolor)->attrs($attr);
    }

    function attrs($attrs) {
        foreach($attrs as $a) {
            $this->attr($a);
        }
        return $this;
    }

    function attr($a, $set = true) {
        if (!in_array($a, self::$ATTRIBUTES)) {
            throw new \InvalidArgumentException(sprintf("%s is not a valid attributes", $a));
        }
        $i = array_search($a, $this->attributes);
        if ($set && false === $i) {
            $this->attributes[]= $a;
        } elseif (!$set && false !== $i)  {
            unset($this->attributes[$i]);
        }
        return $this;
    }


    function color($c) {
        if ($c && !in_array($c, self::$COLORS)) {
            throw new \InvalidArgumentException(sprintf("%s is not a valid color", $c));
        }
        $this->color = $c;
        return $this;
    }


    function bgcolor($c) {
        if ($c && !in_array($c, self::$BGCOLORS)) {
            throw new \InvalidArgumentException(sprintf("%s is not a valid background color", $c));
        }
        $this->bgcolor = $c;
        return $this;
    }


    function __toString() {
        return sprintf(
            self::$ESC,
            join(
                ';',
                array_filter(
                    array_merge(
                        array($this->color, $this->bgcolor),
                        $this->attributes
                    )
                )
            )
            ?:
            0
        );
    }
}
