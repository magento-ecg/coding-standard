<?php

$mystring = 'abc';
$findme = 'a';

if (!strpos($mystring, $findme)) {
    //
}

if (strpos($mystring, $findme)) {
    //
}

if (strpos($mystring, $findme) == false) {
    //
}

if (strpos($mystring, $findme) === false) {
    //
}

if (strpos($mystring, $findme) !== FALSE) {
    //
}

if (FALSE === strpos($mystring, $findme)) {
    //
}

if (false !== strpos($mystring, $findme)) {
    //
}
