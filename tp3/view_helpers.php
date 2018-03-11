<?php

function renderMessage($message, $pseudo) {
    $commands = [
        'me' => renderMe
    ];
    $commandName = 'default';
    if (strpos($message, "/")) {
        // we are in command
        $elements = explode(' ', $message); // all command arguments
        $commandName = substr($elements[0], 1);
        
    }
    return call_user_func($commands[$commandName], array_splice($elements, 0, 1, [$pseudo]));
}

function renderMe($pseudo, $message) {
    return '<p><strong>' . htmlspecialchars($pseudo) . '</strong> <span class="message">'
            . htmlspecialchars($message) . '</span></p>';
}

function renderDefault($pseudo, $message) {
    return '<p><strong>' . htmlspecialchars($pseudo) . '</strong> <span class="message me">'
            . htmlspecialchars($message) . '</span></p>';
}