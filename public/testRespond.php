<?php

// exit('test');

$phpInput = file_get_contents('php://input');
echo urldecode($phpInput);
