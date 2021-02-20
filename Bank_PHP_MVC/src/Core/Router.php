<?php

namespace Bank\Core;

use Bank\Controllers\ErrorController;
use Bank\Controllers\CustomerController;
use Bank\Utils\DependencyInjector;

class Router {
  private $di;
  private $routeMap;

  public function __construct(DependencyInjector $di) {
    $this->di = $di;
    $json = file_get_contents(__DIR__ . '/../../config/routes.json');
    $this->routeMap = json_decode($json, true);
  }
  
  public function route(Request $request): string {
    $result = "";
    $path = $request->getPath();

    foreach ($this->routeMap as $route => $info) {
      $map = [];
      $params = isset($info['params']) ? $info['params'] : null;
      
      if ($this->match($route, $path, $params, $map)) {
        $controllerName = '\Bank\Controllers\\' .
                          $info['controller'] . "Controller";
        $controller = new $controllerName($this->di, $request);

        if (isset($info['login']) && $info['login']) {
          if ($request->getCookies()->has('user')) {
            $customerId = $request->getCookies()->get('user');
            $controller->setCustomerId($customerId);
          }
          else {
            $errorController = new CustomerController($this->di, $request);
            return $errorController->login();
          }
        }
    
        $methodName = $info['method'];
        return call_user_func_array([$controller, $methodName], $map);
      }
    }
  }

  private function match($route, $path, $params, &$map) {
    $routeArray = explode('/', $route);
    $pathArray = explode('/', $path);
    $routeSize = count($routeArray);
    $pathSize = count($pathArray);    
    
    if ($routeSize === $pathSize) {
      for ($index = 0; $index < $routeSize; ++$index) {
        $routeName = $routeArray[$index];
        $pathName = $pathArray[$index];

        if ((strlen($routeName) > 0) && $routeName[0] === ':') {
          $key = substr($routeName, 1);
          $value = $pathName;
          
          if (($params != null) && isset($params[$key]) &&
              !$this->typeMatch($value, $params[$key])) {
            return false;
          }

          $map[$key] = urldecode($value);
        }
        else if ($routeName !== $pathName) {
          return false;
        }
      }
      
      return true;
    }
    
    return false;
  }

  private function typeMatch($value, $type) {
    switch ($type) {
      case 'number':
        return preg_match('/^\d+$/', $value);
    
      case 'string':
        return true; // preg_match('/^.+$/', $value);
    }

    return true;
  }
}