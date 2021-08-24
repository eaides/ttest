<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHP Test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->

    </head>
    <body class="antialiased">
        <h1>PHP Tests</h1>
        Data example:
<pre>
$data = [
    [
        'id' => 1,
        'first_name' => 'Ernesto',
        'last_name' => 'Aides',
        'email' => 'eaides@hotmail.com',
        'data' => 'data for 1',
    ],
    [
        'first_name' => 'Ernesto',
        'last_name' => 'Aides',
        'email' => 'eaides@hotmail.com',
        'data' => 'data for 2',
    ],
    [
        'first_name' => 'Natalio',
        'last_name' => 'Aides',
        'email' => 'eaides@gmail.com',
        'data' => 'data for 3',
    ],
    [
        'first_name' => 'Other',
        'last_name' => 'Last',
        'email' => 'eaides@hotmail.com',
        'data' => 'data for 4',
    ],
];

</pre>
        <h2>Model: Test</h2>

        <h3>1) For test "Insert Ignore" follow: </h3>
        <a href="{{route('testIgnore')}}">Test Insert Ignore</a>
        <p>Usage: <b>$result = Test::insertIgnore($data);</b></p>

        <h3>2) For test "Insert ON DUPLICATE UPDATE" follow: </h3>
        <a href="{{route('testDuplicate')}}">Test Insert On Duplicate</a>
        <p>usage: <b>$result = Test::insertOnDuplicate($data);</b></p>

        <h3>3) For test Facade response time: </h3>
        <form action="{{route('testResponseTime')}}" method="post">
            @csrf
            <label for="url">Url: </label>
            <input id="url" type="text" name="url" val="">
            <button type="submit">get response time</button>
        </form>

        <br><br>&copy; Ernesto Aides (2021)
    </body>
</html>
