<?php

namespace Bank\Domain\Customer;
use Bank\Domain\Customer;

class CustomerFactory {
    public static function factory($type, $id, $firstname, $surname, $email) {
        $classname = __NAMESPACE__ . '\\' . ucfirst($type);
        if (!class_exists($classname)) {
            throw new \InvalidArgumentException('Wrong type.');
        }
        return new $classname($id, $firstname, $surname, $email);
    }
}