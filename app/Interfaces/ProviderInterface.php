<?php

namespace App\Interfaces;

interface ProviderInterface
{
    public function search($search);

    public function one($asin);
}
