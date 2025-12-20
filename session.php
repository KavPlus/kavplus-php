<?php
// session.php
// Always include this BEFORE any HTML output (before <!DOCTYPE ...)

if (session_status() === PHP_SESSION_NONE) {
    // Avoid warnings if anything was already output
    if (!headers_sent()) {
        session_start();
    }
}
