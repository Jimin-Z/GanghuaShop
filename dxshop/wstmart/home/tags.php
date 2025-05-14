<?php 
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 */
return [
    'module_init'=> [
        'wstmart\\home\\behavior\\InitConfig'
    ],
    'action_begin'=> [
        'wstmart\\home\\behavior\\ListenProtectedUrl'
    ]
]
?>