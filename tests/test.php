<?php

require_once '../src/Melp/Term/Ansi/Style.php';
require_once '../src/Melp/Term/Ansi/Cursor.php';
require_once '../src/Melp/Term/Progress/ProgressInterface.php';
require_once '../src/Melp/Term/Progress/Composite.php';
require_once '../src/Melp/Term/Progress/Progress.php';
require_once '../src/Melp/Term/Progress/ProgressBar.php';
require_once '../src/Melp/Term/Progress/ProgressPercentage.php';
require_once '../src/Melp/Term/Style.php';
require_once '../src/Melp/Term/Term.php';
require_once '../src/Melp/Term/StyleCompiler.php';

$t = new \Melp\Term\Term(STDOUT);
$progress = array('/', '-', '\\', '|');

$t->chide();

$report = array(
    'The big brown fox <b>jumped</b> over de <red>jumps</red> over de lazy dog',
    'Hello world !',
);

$formatter = new \Melp\Term\StyleCompiler();

$progress = new Progress(100);
$p = new Composite(
    $formatter->format('[<dim>%bar%</dim> %n% (<b>%perc%</b>)]'),
    array('n' => $progress, 'bar' => new ProgressBar(40), 'perc' => new ProgressPercentage())
);
for ($i = 0; $i <= 100; ++ $i) {
    usleep(rand(3000, 15000));
    $t->csave()->cright($t->width() - 60)->clearleft();
    $progress->setProgress($i);
    $p->write($t->stream, $progress);
    $t->crestore()->csave();
    $k = array_rand($report);
    $formatter->compile($report[$k], $t->stream);
    $t->crestore();
}
echo "\n";
$t->cshow();

$p = new \Melp\Term\StyleCompiler();
$p->compile(
    "Regular\n<b>Bold\n<red>red bold <regular>regular <dim>dim <inv>inverted <default>default</default> dim</inv> dim</dim> regular</regular> <green>green bold</green> red bold</red>\nwhite bold\n</b>\nRegular <dim>dim</dim>",
    STDOUT
);

