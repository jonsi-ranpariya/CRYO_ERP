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
            @if($type == 1)
                <span><b>To: {{ $partyMaster->partyName }}</b></span><br>
                <span>Address: </span>
                {!! chunk_split($partyMaster?->partyDetails['partyAddress'], 50, "$nbsp") !!}<br>
                <span>City: {{ $partyMaster?->partyDetails['partyCity']['label'] }} - {{ $partyMaster?->partyDetails['partyPinCode'] }}</span><br>
                <span>Country: {{ $partyMaster?->partyDetails['partyCountry']['label'] }}</span><br>
                @if(empty($partyMaster?->partyDetails['partyPhoneNo']))
                    <br><br>
                    <span>Ph No.: {{ $partyMaster?->partyDetails['partyCountryCode'] }} - {{ $partyMaster?->partyDetails['partyPhoneNo'] }}</span><br><br><br>
                @endif
                <span>Email ID: {{ $partyMaster?->partyDetails['partyEmilId'] }}</span><br>
                <span>Website: {{ $partyMaster?->partyDetails['partyWebsite'] }}</span><br>
            @endif
            @if($type == 2)
                <span><b>To: {{ $partyMaster->partyName }}</b></span><br>
                <span>Address: </span>
                {!! chunk_split($partyMaster?->partyAddress['partyAddress'], 50, "$nbsp") !!}<br>
                <span>City: {{ $partyMaster?->partyAddress['partyCity']['label'] }} - {{ $partyMaster?->partyAddress['partyPinCode'] }}</span><br>
                <span>Country: {{ $partyMaster?->partyAddress['partyCountry']['label'] }}</span><br>
                @if(empty($partyMaster?->partyAddress['partyPhoneNo']))
                    <br><br>
                    <span>Ph No.: {{ $partyMaster?->partyAddress['partyPhoneNoCode'] }} - {{ $partyMaster?->partyAddress['partyPhoneNo'] }}</span><br><br><br>
                @endif
                <span>Email ID: {{ $partyMaster?->partyAddress['partyEmilId'] }}</span><br>
                <span>Website: {{ $partyMaster?->partyAddress['partyWebsite'] }}</span><br>
            @endif
        </td>
    </tr>
</table>

</body>
</html>
