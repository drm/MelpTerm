<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */

class ProgressBar implements ProgressInterface {
    function __construct($width, $fill = '#', $background = ' ') {
        $this->width = $width;
        $this->background = $background;
        $this->fill = $fill;
    }


    function write($stream, Progress $progress) {
        $fill = round($progress->asFloat() * ($this->width));
        fwrite($stream, str_repeat($this->fill, $fill));
        fwrite($stream, str_repeat($this->background, $this->width - $fill));
    }
}