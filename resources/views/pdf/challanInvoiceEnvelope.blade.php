<!DOCTYPE html>
<html>
<head>
    <title>Envelope</title>
</head>
<body>
@php
    $nbsp = "<br>".str_repeat('&nbsp;', 18);
@endphp
<table>
    <tr>
        <td width="45%"></td>
        <td width="55%">
            <br>
            <span>
                Kind Attn: {{ $data['kindAttnName'] }}
                @if(!empty($data['kindAttnNumber']))
                    - ({{ $data['kindAttnNumber'] }})
                @endif
            </span><br>
            <span><b>To: {{ $data['companyName'] }}</b></span><br>
            <span>Address: </span>
            {!! chunk_split($data['address'], 50, "$nbsp") !!}<br>
            <span>City: {{ $data['city'] }} - {{ $data['pincode'] }}</span><br>
            <span>Country: {{ $data['country'] }}</span><br>@if(empty($data['phoneNumber']))<br><br>@endif
            @if(!empty($data['phoneNumber']))
                <span>Ph No.: {{ $data['phoneCode'] }} - {{ $data['phoneNumber'] }}</span><br><br><br>
            @endif
            <span>Email ID: {{ $data['email'] }}</span><br>
            <span>Website: {{ $data['website'] }}</span><br>
        </td>
    </tr>
</table>

</body>
</html>
