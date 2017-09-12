<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/22
 * Time: 下午1:37
 */
session_start();
session_destroy();
echo '<meta http-equiv=REFRESH CONTENT=0;url=./index.php>';