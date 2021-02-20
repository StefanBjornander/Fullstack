<?php

namespace Bank\Core;

class Request {
    const GET = "GET";
    const POST = "POST";

    private $domain;
    private $path;
    private $method;
    private $params;
    private $cookies;

    public function __construct() {
        $this->domain = $_SERVER["HTTP_HOST"];
        $pathArray = explode("?", $_SERVER["REQUEST_URI"]);
        $this->path = substr($pathArray[0], 1);
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->params = new FilteredMap(array_merge($_POST, $_GET));
        $this->cookies = new FilteredMap($_COOKIE);
        
        /*echo "uri: " . $_SERVER["REQUEST_URI"] . "<br/>";
        echo "domain: $this->domain <br/>";
        echo "path: $this->path <br/>";
        echo "method: $this->method <br/>";
        echo "params: $this->params <br/>";
        echo "cookies: $this->cookies <p/>";*/
    }

    public function getUrl(): string {
        return $this->domain . $this->path;
    }

    public function getDomain(): string {
        return $this->domain;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function isPost(): bool {
        return $this->method === self::POST;
    }

    public function isGet(): bool {
        return $this->method === self::GET;
    }

    public function getParams(): FilteredMap {
        return $this->params;
    }

    public function getCookies(): FilteredMap {
        return $this->cookies;
    }
    
    public function __toString() {
        return "path: $this->path, domain: $this->domain, " .
               "method: $this->method, params: $this->params, " .
               "cookies: $this->cookies";
    }
}