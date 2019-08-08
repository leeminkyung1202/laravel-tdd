<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css">
</head>
<body>
    <form method="POST" action="/projects" class="container" style="padding-top: 40px;">
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
            </div>
        </div>
    </form>
</body>
</html>
