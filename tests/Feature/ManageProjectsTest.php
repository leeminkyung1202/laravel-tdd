<?php

namespace Tests\Feature;

// 추상 클래스 확장. 테스트 코드 하기 위한 필수 값
use Tests\TestCase;

// $this->faker 를 사용해서 페이커 데이터로 테스트 하기 위한 거.
use Illuminate\Foundation\Testing\WithFaker;

// 테스트 전에 데이터베이스 마이그레이션 하기 위한 거.
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    // 위에 선언 해줬는데 왜 또 여기서 use 한 이유는 WithFaker, RefreshDatabase 메소드들 전부 ProjectsTest class 꺼가 된다.
    use WithFaker, RefreshDatabase;

    /**
     * @test
     * Auth Middleware 타기 때문에 글을 작성 시 로그인이 안되어 있으면 로그인 페이지로 보낸다. 경로가 있는지 체크
     */
    public function guests_cannot_manage_projects ()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');

        // toArray 는 컬렉션을 일반 php 로 변환
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /**
     * @test
     * ProjectsController 가 제대로 작동 해주는지 확인
     */
    public function a_user_can_create_a_project ()
    {
        // 라라벨 에러 핸들링을 타겠다
        $this->withoutExceptionHandling();

        // 현재 로그인 한 사용자를 설정
        $this->actingAs(factory('App\User')->create());

        $this->get('/projects/create')->assertStatus(200);

        // 내가 테스트 할 배열 :: 내가 적은 게시글 제목과 내용
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        // post '/projects' uri 로 요청을 하고, $attributes 안에 있는 값을 보낸 후, 응답이 주어진 URI 로 리다이렉트
        // assertRedirect 은 라우터에서 ProjectsController->store 로 간 뒤 /projects 로 리턴하는 데 이게 잘 되는지 체크하는 것 :: 리스트로 잘 빠지는지
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        // projects 테이블에 $attributes 에서 생성된 페이커 데이터와 같은 값이 있는 지 체크 :: 데이터 잘 들어갔는지 확인 과정
        $this->assertDatabaseHas('projects', $attributes);

        // get '/projects' uri 로 요청을 하고, $attributes 안에 있는 문자열이 응답 내에 포함 되어 있다고 가정 :: 등록 한 내용이 리스트에 타이틀로 잘 나오나 체크
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /**
     * @test
     * View 페이지에 값이 잘 들어가는지 확인 (View 잘 보이는지)
     */
    public function a_user_can_view_their_project()
    {
        // 팩토리에서 생성된 유저를 현재 로그인 한 사용자로 설정 하겠다.
        $this->be(factory('App\User')->create());

        // 테스트에 대한 예외 처리를 비활성화
        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /**
     * @test
     * 다른 사람이 작성한 글은 못보고 내가 작성한 글만 볼 수 있다.
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others ()
    {
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test
     * ProjectsController 에 title 유효성 검사 확인
     */
    public function a_project_requires_a_title ()
    {
        // 현재 로그인 한 사용자를 설정
        $this->actingAs(factory('App\User')->create());

        // 지정된 모델의 raw 속성 배열 가져옴 (터미널에 php artisan tinker 해서 활성화 후 factory('App\Project')->make() 치면 어떤 데이터가 들어갈지 미리 확인 가능 )
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
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
