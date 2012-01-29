<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */

namespace Melp\Term\Ansi;

final class Cursor {
    const UP        = '%dA';
    const DOWN      = '%dB';
    const FWD       = '%dC';
    const BWD       = '%dD';
    const CLEAR     = '2J';
    const MOVE      = '%2$s;%1$sH';
    const SAVE      = 's';
    const RESTORE   = 'u';
    const CLEARLN   = '2K';
    const CLEARLEFT = '1K';
    const CLEARRIGHT = 'K';
    const POS       = '6n';
    const HIDE      = '?25l';
    const SHOW      = '?25h';
}