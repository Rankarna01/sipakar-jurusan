<?php
/**
 * Class Router
 * Router sederhana berbasis query string ?page=controller/method/param
 * Menjaga agar seluruh request diarahkan lewat satu pintu (index.php)
 * demi keamanan dan konsistensi.
 */

class Router
{
    private string $controllerPath = CONTROLLER_PATH;
    private string $defaultController = 'HomeController';
    private string $defaultMethod = 'index';

    public function dispatch(): void
    {
        $url = $this->parseUrl();

        $controllerName = !empty($url[0]) ? ucfirst($this->sanitize($url[0])) . 'Controller' : $this->defaultController;
        $controllerFile = $this->controllerPath . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            $this->notFound();
            return;
        }

        require_once CORE_PATH . 'Controller.php';
        require_once CORE_PATH . 'Model.php';
        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            $this->notFound();
            return;
        }

        $controller = new $controllerName();

        $method = !empty($url[1]) ? $this->sanitize($url[1]) : $this->defaultMethod;
        unset($url[0], $url[1]);
        $params = array_values($url);

        if (!method_exists($controller, $method)) {
            $this->notFound();
            return;
        }

        // Cegah pemanggilan method internal PHP secara tidak sengaja (magic methods)
        if (strpos($method, '__') === 0) {
            $this->notFound();
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }

    private function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    private function sanitize(string $input): string
    {
        return preg_replace('/[^a-zA-Z0-9_-]/', '', $input);
    }

    private function notFound(): void
    {
        http_response_code(404);
        $viewFile = VIEW_PATH . 'partials/404.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo '404 - Halaman tidak ditemukan';
        }
        exit;
    }
}
