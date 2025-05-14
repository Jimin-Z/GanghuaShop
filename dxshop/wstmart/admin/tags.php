<?php 
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 */
return [
    'module_init'=> [
        'wstmart\\admin\\behavior\\InitConfig'
    ],
    'action_begin'=> [
        'wstmart\\admin\\behavior\\ListenLoginStatus',
        'wstmart\\admin\\behavior\\ListenPrivilege',
        'wstmart\\admin\\behavior\\ListenOperate'
    ]
]
?>