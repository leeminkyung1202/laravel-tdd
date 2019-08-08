@extends ('layouts.app')

@section('content')
    <form method="POST" action="/projects">
        @csrf
        <h1 class="heading is-1">작성</h1>

        <div class="fieId">
            <label class="label" for="title">제목</label>

            <div class="control">
                <input type="text" class="input" name="title" placeholder="title" />
            </div>
        </div>

        <div class="fieId">
            <label class="label" for="description">내용</label>

            <div class="control">
                <textarea name="description" class="textarea"></textarea>
            </div>
        </div>

        <div class="fieId">
            <div class="control">
                <button type="submit" class="button is-link">생성</button>
                <a href="/projects">취소</a>
            </div>
        </div>
    </form>
@endsection
