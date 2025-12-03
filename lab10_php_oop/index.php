<?php
/**
 * index.php - Main Router dengan OOP
 */

// Error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
require_once 'config.php';

// Autoload classes
spl_autoload_register(function ($class_name) {
    $paths = array(
        'lib/' . $class_name . '.php',
        'models/' . $class_name . '.php',
        'controllers/' . $class_name . '.php'
    );
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Ambil parameter page dari URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Pisahkan module dan action
$parts = explode('/', $page);
$module = isset($parts[0]) ? $parts[0] : 'home';
$action = isset($parts[1]) ? $parts[1] : 'index';

// Include header
include('views/header.php');

// Routing logic dengan OOP Controller
try {
    switch($module) {
        case 'barang':
            if (!file_exists('controllers/BarangController.php')) {
                throw new Exception("BarangController.php tidak ditemukan!");
            }
            
            require_once 'controllers/BarangController.php';
            $controller = new BarangController();
            
            switch($action) {
                case 'index':
                case 'list':
                    $controller->index();
                    break;
                case 'add':
                    $controller->add();
                    break;
                case 'edit':
                    $id = isset($_GET['id']) ? $_GET['id'] : null;
                    $controller->edit($id);
                    break;
                case 'delete':
                    $id = isset($_GET['id']) ? $_GET['id'] : null;
                    $controller->delete($id);
                    break;
                default:
                    echo "<div class='content'><h2>404 - Action tidak ditemukan</h2></div>";
            }
            break;
        
        case 'home':
        default:
            if (file_exists('views/dashboard.php')) {
                include('views/dashboard.php');
            } else {
                echo "<div class='content'><h2>Dashboard tidak ditemukan</h2></div>";
            }
            break;
    }
} catch (Exception $e) {
    echo "<div class='content'>";
    echo "<h2>Error</h2>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    echo "</div>";
}

// Include footer
include('views/footer.php');
?>