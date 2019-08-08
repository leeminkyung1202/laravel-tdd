<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    // 테스트 전에 데이터베이스 마이그레이션 하기 위한 거.
    use RefreshDatabase;

    /**
     * @test
     * projects 테이블에 insert 시 사용자 id 가 있는지 체크
     */
    public function a_user_has_projects ()
    {
        $user = factory('App\User')->create();

        // assertInstanceOf 변수가 주어진 유형임을 확인. Collection 배열이나 객체를 좀 더 효율적으로 쓸수 있게 해줌.
        // User 모델의 projects 함수가 잘 동작하는지 체크
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
