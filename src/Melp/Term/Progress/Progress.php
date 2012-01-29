<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */



class Progress implements ProgressInterface {
    function __construct($goal) {
        $this->goal = $goal;
        $this->progress = 0;
    }


    function setProgress($n) {
        $this->progress = $n;
    }


    function asFloat() {
        return $this->progress / $this->goal;
    }


    function __toString() {
        return sprintf('%d / %d', $this->progress, $this->goal);
    }


    function __invoke($n) {
        $this->setProgress($n);
    }

    function write($stream, Progress $progress) {
        fwrite($stream, (string) $this);
    }
}