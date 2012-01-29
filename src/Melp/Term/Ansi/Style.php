<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */

namespace Melp\Term\Ansi;

final class Style {
    const RESET         = 0;

    const BOLD          = 1;
    const DIM           = 2;
    const UNDERLINE     = 4;
    const BLINK         = 5;
    const INVERSE       = 7;
    const HIDE          = 8;
    const STRIKE        = 9;

    const NOBOLD        = 22;
    const NODIM         = 22;
    const NOUNDERLINE   = 24;
    const NOBLINK       = 25;
    const NOINVERSE     = 27;
    const NOSTRIKE      = 29;

    const BLACK         = 30;
    const RED           = 31;
    const GREEN         = 32;
    const YELLOW        = 33;
    const BLUE          = 34;
    const MAGENTA       = 35;
    const CYAN          = 36;
    const WHITE         = 37;
    const DEFAULT_      = 39;

    const BBLACK        = 40;
    const BRED          = 41;
    const BGREEN        = 42;
    const BYELLOW       = 43;
    const BBLUE         = 44;
    const BMAGENTA      = 45;
    const BCYAN         = 46;
    const BWHITE        = 47;
    const BDEFAULT      = 49;
}
