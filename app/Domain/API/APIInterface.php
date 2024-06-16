<?php

namespace App\Domain\API;

interface APIInterface
{
    public function baseUrl();

    public function url();

    public function extendUrl($extend): string;
}
