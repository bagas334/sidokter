<?php

namespace Tests;

use App\Services\BasicRequestServiceInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected BasicRequestServiceInterface $service;
}
