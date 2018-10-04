<?php
/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE); // Error display - OFF in production env or real server
ini_set('log_errors', TRUE); // Error logging
ini_set('error_log', '../logs/errors.log'); // Logging file
ini_set('log_errors_max_len', 1024); // Logging file size