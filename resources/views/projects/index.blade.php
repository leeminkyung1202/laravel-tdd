@extends ('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <h1 class="mr-auto">리스트</h1>
        <a href="/projects/create">작성하기</a>
    </div>

    <ul>
        @forelse ($projects as $project)
            <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>
        @empty
            <li>데이터 없음.</li>
        @endforelse
    </ul>
@endsection
