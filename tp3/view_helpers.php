<?php

function renderMessage($message, $pseudo) {
    $commandName = 'default';
    if (strpos($message, "/me") === 0) {
        // we are in command
	return renderMe($pseudo, substr($message, 3));
    }
    return renderDefault($pseudo, $message);
}

function renderMe($pseudo, $message) {
    return '<p><strong>' . htmlspecialchars($pseudo) . '</strong> <span class="message">'
            . htmlspecialchars($message) . '</span></p>';
}

function renderDefault($pseudo, $message) {
    return '<p><strong>' . htmlspecialchars($pseudo) . '</strong> <span class="message me">'
            . htmlspecialchars($message) . '</span></p>';
}
