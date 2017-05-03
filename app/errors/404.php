<?php
/**
 * ეს გვერდი გამოიძახება როცა გამოიძახებ PageFunctions::show404();
 */
header('Content-Type:text/plain; charset=utf-8;');
header('HTTP/1.0 404 Not Found');
echo "404 უცნაური მოთხოვნა";
exit();