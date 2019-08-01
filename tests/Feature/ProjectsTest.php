<?php

namespace Tests\Feature;

// 추상 클래스 확장. 테스트 코드 하기 위한 필수 값
use Tests\TestCase;

// $this->faker 를 사용해서 페이커 데이터로 테스트 하기 위한 거.
use Illuminate\Foundation\Testing\WithFaker;

// 테스트 전에 데이터베이스 마이그레이션 하기 위한 거.
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    // 위에 선언 해줬는데 왜 또 여기서 use 한 이유는 WithFaker, RefreshDatabase 메소드들 전부 ProjectsTest class 꺼가 된다.
    use WithFaker, RefreshDatabase;

    /**
     * @test
     * ProjectsController 가 제대로 작동 해주는지 확인
     */
    public function a_user_can_create_a_project ()
    {
        // 라라벨 에러 핸들링을 타겠다
        $this->withExceptionHandling();

        // 내가 테스트 할 배열
        $attrbutes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        // post '/projects' uri 로 요청을 하고, $attrbutes 안에 있는 값을 보낸 후, 응답이 주어진 URI 로 리다이렉트
        // assertRedirect 은 라우터에서 ProjectsController->store 로 간 뒤 /projects 로 리턴하는 데 이게 잘 되는지 체크하는 것
        $this->post('/projects', $attrbutes)->assertRedirect('/projects');

        // projects 테이블에 $attrbutes 에서 생성된 페이커 데이터와 같은 값이 있는 지 체크
        $this->assertDatabaseHas('projects', $attrbutes);

        // get '/projects' uri 로 요청을 하고, $attrbutes 안에 있는 문자열이 응답 내에 포함 되어 있다고 가정
        // 등록 한 내용이 리스트에 타이틀로 잘 나오나 체크
        $this->get('/projects')->assertSee($attrbutes['title']);
    }

    /**
     * @test
     * View 페이지에 값이 잘 들어가는지 확인
     */
    public function a_user_can_view_a_project()
    {
        // 테스트에 대한 예외 처리를 비활성화
        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /**
     * @test
     * ProjectsController 에 title 유효성 검사 확인
     */
    public function a_project_requires_a_title ()
    {
        // 팩토리에서 생성된 데이터 체크 (터미널에 php artisan tinker 해서 활성화 후 factory('App\Project')->make() 치면 어떤 데이터가 들어갈지 미리 확인 가능 )
        $attributes = factory('App\Project')->raw(['title' => '']);

        // 세션에 주어진 필드에 오류가 있는지 체크. validate 설정 되어 있어야 함.
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     * ProjectsController 에 description 유효성 검사 확인
     */
    public function a_project_requires_a_description ()
    {
        $arrtibutes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $arrtibutes)->assertSessionHasErrors('description');
    }
}
