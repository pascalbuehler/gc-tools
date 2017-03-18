<?php

return [
    'FindEncryptedNumbers' => [
        'class' => Tool\FindEncryptedNumbers\FindEncryptedNumbers::class,
        'route' => 'find-encrypted-numbers',
        'parameters' => [],
        'description' => 'Findet Zahlen (null, eins, ...) in einem (monoalphabetisch) codierten Text',
        'author' => 'frigidor',
    ],
];