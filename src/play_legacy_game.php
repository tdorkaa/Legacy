<?php

namespace Game;

(new GameRunner(
    [
        'Chet',
        'Pat',
        'Sue'
    ],
    new CategoryCollection(
        new Category('Pop', 1, [0,4,8]),
        new Category('Science', 1, [1,5,9]),
        new Category('Sports', 1, [2,6,10]),
        new Category('Rock', 1, [3,7,11])
    )
))->run();
