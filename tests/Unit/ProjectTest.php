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
    public function it_has_a_path ()
    {
        $project = factory('App\Project')->create();

        // assertEquals 안에 두 값이 맞는지 확인
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /**
     * @test
     */
    public function it_belongs_to_an_owner ()
    {
        $project = factory('App\Project')->create();

        // assertInstanceOf 변수가 주어진 유형임을 확인.
        // $project->owner 이 App\User 여기서 만들어진건지 확인
        $this->assertInstanceOf('App\User', $project->owner);
    }
}
