<?php
use Event\Emitter;

require 'vendor/autoload.php';

$emitter = Emitter::getInstance();
$emitter->on('Comment.created', function ($firstname, $lastname) {
    echo $firstname . ' ' . $lastname . ' a commenté un nouveau commentaire';
});

$emitter->emit('Comment.created', 'John', 'Doe');
$emitter->emit('User.new');