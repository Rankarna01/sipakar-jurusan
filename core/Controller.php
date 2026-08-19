<?php
/**
 * Class Controller
 * Controller dasar yang menyediakan method untuk memuat view dan model.
 */

class Controller
{
    /**
     * Memuat file view dan mengoper data ke dalamnya
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = VIEW_PATH . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new Exception("View tidak ditemukan: {$view}");
        }
        require $viewFile;
    }

    /**
     * Memuat model secara otomatis
     */
    protected function model(string $model): object
    {
        $modelFile = MODEL_PATH . $model . '.php';
        if (!file_exists($modelFile)) {
            throw new Exception("Model tidak ditemukan: {$model}");
        }
        require_once $modelFile;
        return new $model();
    }

    /**
     * Mengirim response JSON (untuk AJAX)
     */
    protected function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Redirect ke URL tertentu
     */
    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . ltrim($path, '/'));
        exit;
    }

    /**
     * Validasi bahwa request adalah POST, jika tidak tolak akses
     */
    protected function onlyPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Method Not Allowed');
        }
    }
}
