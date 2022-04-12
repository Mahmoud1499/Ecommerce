<?php

// $lang = array(
//     'osama' => 'zero'
// );
// echo $lang['osama'];

function lang($phrase)
{

    static $lang = array(
        // 'massage' => 'welcome',
        // 'admin' => 'adminstratoer
        //dashboared

        //nav bar
        'HOME PAGE' => 'Home Page',
        'CATEGORIES' => 'Categories',
        'ITEMS' => 'Items',
        'MEMBERS' => 'Members',
        'COMMENTS' => 'Comments',
        'STATISTICS' => 'Statistics',
        'LOGS' => 'logs',
        'EDIT PROFILE' => 'Edit Profile',
        'SETTINGS' => 'Settings',
        'LOGOUT' => 'Logout',

    );

    return $lang[$phrase];
}
