<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * URL 이 올바른지 체크
     */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        // assertEquals 안에 두 값이 맞는지 확인
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
}
