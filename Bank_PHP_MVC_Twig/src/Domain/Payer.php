<?php

namespace Bank\Domain;

interface Payer {
    public function pay($amount);
    public function isExtentOfTaxes();
}