<?php

/**
 * Включение ошибок для дебага
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/**
 * Подключение констант
 */
include_once "consts.php";

/**
 * Подключение методов необходимых для приложения
 */
include_once DIR_CTRL_APP . "Methods.php";

/**
 * Подключение фронта
 */
Project\Methods::include_file( DIR_VIEW );