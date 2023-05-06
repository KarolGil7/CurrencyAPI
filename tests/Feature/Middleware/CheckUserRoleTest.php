<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CheckUserRoleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
