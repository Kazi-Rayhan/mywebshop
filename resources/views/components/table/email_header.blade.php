@props(['tableHeaders'])
<tr align="left">
    @foreach ($tableHeaders as $header)
    <th>{{ $header }}</th>
    @endforeach
</tr>