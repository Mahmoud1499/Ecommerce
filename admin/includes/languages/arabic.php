<?php

// $lang = array(
//     'osama' => 'zero'
// );
// echo $lang['osama'];

function lang($phrase)
{

    static $lang = array(
        'massage' => 'ahlan',
        'admin' => 'arabic admin'
    );

    return $lang[$phrase];
}
