<?php

const BASE_URL = "https://webprog2-beadando/";

const DATA_FILE = PRIVATE_DIR . "data/data.json";

const THEME_LANG = "HU";
const THEME_CHARSET = "utf-8";
const THEME_DESCRIPTION = "Kovács Dániel ADEJ1R beadandó munka";
const THEME_AUTHOR = "Kovács Dániel ADEJ1R";
const DEFAULT_TITLE = "ADEj1R beadandó";

const THEME_CSS = [
    BASE_URL . "public/assets/bootstrap/css/bootstrap.css",
];

const THEME_JS = [
    BASE_URL . "public/assets/bootstrap/js/bootstrap.bundle.js",
];

const THEME_MENU = [
    [
        "TITLE" => "Megjelenítés",
        "URL" => "/index.php",
        "OUTER_CLASSES" => [
            "nav-item",
        ],
        "INNER_CLASSES" => [
            "nav-link",
            "active"
        ]
    ],
    [
        "TITLE" => "Új rekord",
        "URL" => "/index.php?P=createUpdate",
        "OUTER_CLASSES" => [
            "nav-item",
        ],
        "INNER_CLASSES" => [
            "nav-link"
        ]
    ],
    [
        "TITLE" => "Menü1",
        "URL" => "#",
        "OUTER_CLASSES" => [
            "nav-item",
        ],
        "INNER_CLASSES" => [
            "nav-link"
        ]
    ],
    [
        "TITLE" => "Menü1",
        "URL" => "#",
        "OUTER_CLASSES" => [
            "nav-item",
        ],
        "INNER_CLASSES" => [
            "nav-link"
        ]
    ],
    [
        "TITLE" => "Menü1",
        "URL" => "#",
        "OUTER_CLASSES" => [
            "nav-item",
        ],
        "INNER_CLASSES" => [
            "nav-link"
        ]
    ],

];

const MUFAJOK = [
    [
        "value" => "tragédia",
        "label" => "Tragédia",
    ],
    [
        "value" => "komédia",
        "label" => "Komédia",
    ],
    [
        "value" => "dráma",
        "label" => "Dráma",
    ],
    [
        "value" => "musical",
        "label" => "Musical",
    ],
    [
        "value" => "opera",
        "label" => "Opera",
    ],
];

const SZINPADOK = [
    [
        "value" => "nagyszínpad",
        "label" => "Nagyszínpad",
    ],
    [
        "value" => "kamaraszínpad",
        "label" => "Kamaraszínpad",
    ],
];

const LABELS = [
    "iro" => "színdarab írója",
    "szindarab" => "színdarab címe",
    "rendezo" => "színdarab rendezője",
    "mufaj" => "műfaj",
    "szinpad" => "színpad",
];


const APP_NAMESPACE = "ADEJ1R";