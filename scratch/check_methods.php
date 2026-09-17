<?php
define('BASEPATH', true);
define('APPPATH', dirname(__DIR__) . '/application/');

// Mock CodeIgniter classes
class CI_Controller {}
class CI_Model {}

// Include core classes
require_once APPPATH . 'core/MY_Controller.php';
require_once APPPATH . 'core/MY_Model.php';
require_once APPPATH . 'services/BaseService.php';

// Include all models
foreach (glob(APPPATH . 'models/*.php') as $file) {
    require_once $file;
}

// Include all services
foreach (glob(APPPATH . 'services/*.php') as $file) {
    require_once $file;
}

// Now scan all controllers, services and models for method calls
$files_to_scan = array_merge(
    glob(APPPATH . 'controllers/*.php'),
    glob(APPPATH . 'services/*.php'),
    glob(APPPATH . 'models/*.php')
);

$errors = [];

foreach ($files_to_scan as $file) {
    $content = file_get_contents($file);
    $basename = basename($file);
    
    // Find $this->xxx_model->method(
    preg_match_all('/\$this->([a-zA-Z0-9_]+_model)->([a-zA-Z0-9_]+)\(/', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $model_prop = $match[1];
        $method = $match[2];
        
        // Convert to class name
        $class_name = '';
        if (strcasecmp($model_prop, 'presensikelas_model') === 0) {
            $class_name = 'Presensikelas_model';
        } else {
            $parts = explode('_', $model_prop);
            $class_name = ucfirst($parts[0]) . '_model';
        }
        
        if (!class_exists($class_name)) {
            $errors[] = "$basename calls $model_prop->$method() but class $class_name is not defined.";
            continue;
        }
        
        if (!method_exists($class_name, $method)) {
            $errors[] = "$basename calls $model_prop->$method() but $class_name::$method() is NOT defined.";
        }
    }

    // Find $this->xxxService->method(
    preg_match_all('/\$this->([a-zA-Z0-9_]+Service)->([a-zA-Z0-9_]+)\(/', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $service_prop = $match[1];
        $method = $match[2];
        
        $class_name = ucfirst($service_prop);
        if (!class_exists($class_name)) {
            $errors[] = "$basename calls $service_prop->$method() but class $class_name is not defined.";
            continue;
        }
        
        if (!method_exists($class_name, $method)) {
            $errors[] = "$basename calls $service_prop->$method() but $class_name::$method() is NOT defined.";
        }
    }
}

echo "=== METHOD CALL VERIFICATION ===\n\n";
if (empty($errors)) {
    echo "No undefined model/service method calls found!\n";
} else {
    foreach (array_unique($errors) as $err) {
        echo "[ERROR] " . $err . "\n";
    }
}
?>
