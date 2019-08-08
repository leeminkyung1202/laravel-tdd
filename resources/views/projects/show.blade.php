@extends ('layouts.app')

@section('content')
    <h1>{{ $project->title  }}</h1>
    <div>{{ $project->description  }}</div>
    <a href="/projects">뒤로가기</a>
@endsection
