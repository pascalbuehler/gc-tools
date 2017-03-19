<?php

return [
    'StringReverse' => [
        'class' => Tool\StringReverse\StringReverse::class,
        'route' => 'string-reverse',
        'parameters' => [],
        'description' => 'Kehrt einen Text zeilenweise um',
        'author' => 'frigidor',
        'active' => true,
    ],
    'RotXBox' => [
        'class' => Tool\RotXBox\RotXBox::class,
        'route' => 'rot-x-box',
        'parameters' => [],
        'description' => 'Wendet eine Rot-X Operation anhand von Spalten- und Zeilenoffsets an.',
        'author' => 'frigidor',
        'active' => true,
    ],
//    'FindEncryptedNumbers' => [
//        'class' => Tool\FindEncryptedNumbers\FindEncryptedNumbers::class,
//        'route' => 'find-encrypted-numbers',
//        'parameters' => [],
//        'description' => 'Findet Zahlen (null, eins, ...) in einem (monoalphabetisch) codierten Text',
//        'author' => 'frigidor',
//    ],
];