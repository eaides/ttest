@php
if (!isset($data[0]) || !is_array($data[0])) {
    $data = [$data];
}
@endphp
Input Data:
<table border="1">
<thead>
    <tr>
        <th colspan="1">id</th>
        <th>first_name</th>
        <th colspan="1">last_name</th>
        <th colspan="1">email</th>
        <th colspan="1">data</th>
    </tr>
    <tr>
        <td>Primary</td>
        <td colspan="2">Unique</td>
        <td>Unique</td>
        <td>&nbsp;</td>
    </tr>
</thead>
<tbody>
@foreach($data as $one)
<tr>
    <td>{{array_key_exists('id', $one)?$one['id']:" "}}</td>
    <td>{{array_key_exists('first_name', $one)?$one['first_name']:" "}}</td>
    <td>{{array_key_exists('last_name', $one)?$one['last_name']:" "}}</td>
    <td>{{array_key_exists('email', $one)?$one['email']:" "}}</td>
    <td>{{array_key_exists('data', $one)?$one['data']:" "}}</td>
</tr>
@endforeach
</tbody>
</table>

<br>

DB Data:
<table border="1">
    <thead>
    <tr>
        <th colspan="1">id</th>
        <th>first_name</th>
        <th colspan="1">last_name</th>
        <th colspan="1">email</th>
        <th colspan="1">data</th>
    </tr>
    <tr>
        <td>Primary</td>
        <td colspan="2">Unique</td>
        <td>Unique</td>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    @foreach($db as $one)
        <tr>
            <td>{{$one->id}}</td>
            <td>{{$one->first_name}}</td>
            <td>{{$one->last_name}}</td>
            <td>{{$one->email}}</td>
            <td>{{$one->data}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br>
Affected rows: <b>{{ $result }}</b> (returned by MySql - insert count as 1; on duplicate key updates count as 2)
<br><br>

<a href="\">Return</a>