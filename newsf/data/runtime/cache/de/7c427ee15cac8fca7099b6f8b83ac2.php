<?php
//000000000000
 exit();?>
s:200:"SELECT `a`.* FROM `ey_archives` `a` WHERE  (  a.typeid IN (2,12,13,14,15) AND a.channel IN (1) AND a.arcrank > -1 AND a.status = 1 AND a.is_del = 0 ) ORDER BY a.sort_order asc, a.add_time desc LIMIT 4";