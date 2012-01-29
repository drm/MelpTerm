<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @copyright 2012 Gerard van Helden
 *
 * For Licensing information, see the LICENSE file included with this project.
 */

class Composite implements ProgressInterface {
    function __construct($template, array $items = array()) {
        $this->template = $template;
        $this->items = array();
        foreach ($items as $placeholder => $progress) {
            $this->add($placeholder, $progress);
        }
    }


    function add($placeholder, ProgressInterface $p) {
        $this->items[$placeholder] = $p;
    }


    function write($stream, Progress $progress) {
        $res = $this->template;
        foreach ($this->items as $key => $item) {
            $var = fopen('php://memory', 'rw');
            $item->write($var, $progress);
            rewind($var);
            $res = str_replace('%' . $key . '%', stream_get_contents($var), $res);
            fclose($var);
        }
        fwrite($stream, $res);
    }

}