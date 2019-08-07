<?php

namespace Tests\Unit;

use mysql_xdevapi\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    // 테스트 전에 데이터베이스 마이그레이션 하기 위한 거.
    use RefreshDatabase;

    /**
     * @test
     * 사용자 id 가 있음을 확인
     */
    public function a_user_has_projects ()
    {
        $user = factory('App\User')->create();

        // assertInstanceOf 변수가 주어진 유형임을 확인. Collection 관계에 있는 모든 멀티 레코드 결과 값을 봄.
        // assertInstanceOf 여기서 에러남. 운동 뒤에 확인 필요
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
