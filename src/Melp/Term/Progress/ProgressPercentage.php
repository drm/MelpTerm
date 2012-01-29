<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */

class ProgressPercentage implements ProgressInterface {
    function write($stream, Progress $progress) {
        fwrite($stream, sprintf('%d %%', round($progress->asFloat() * 100)));
    }
}