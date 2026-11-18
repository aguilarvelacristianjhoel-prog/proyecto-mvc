<?php
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function route(string $path=''): string { return BASE_URL . ltrim($path, '/'); }
function redirectTo(string $path): void { header('Location: '.route($path)); exit; }
function csrfToken(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(24));
    return $_SESSION['csrf'];
}
function validCsrf(): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    return isset($_POST['csrf'],$_SESSION['csrf']) && hash_equals($_SESSION['csrf'],(string)$_POST['csrf']);
}
function requirePost(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validCsrf()) { http_response_code(403); exit('Solicitud no permitida'); }
}
