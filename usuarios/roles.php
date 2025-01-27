<?php

// Define an array of roles and their corresponding allowed menu options
$allowedOptions = array(
    'admin' => array('dashboard', 'matricula', 'responsables', 'matriculados', 'listado','culminados','inactivos', 'opciones', 'logout'),
    'rectorado' => array('dashboard',  'matriculados', 'listado','culminados',  'logout'),
    'docente' => array('dashboard','listado' , 'logout'),
    'secretariado' => array('dashboard','matricula', 'responsables', 'matriculados', 'listado','culminados', 'logout')

);

function isOptionAllowed($option, $role)
{
    global $allowedOptions;
    if (isset($allowedOptions[$role]) && in_array($option, $allowedOptions[$role])) {
        return true;
    }
    return false;
}
?>