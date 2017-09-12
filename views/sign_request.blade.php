<html>

<body>
<form method="POST" action="{{url('authenticate')}}">
    <div>Signature: <input name="signature" type="text" /></div>
    <div>Public Key: <input name="public_key" type="text" /></div>
    <div>URI: <input name="uri" type="text"></div>
    {{ csrf_field() }}
    <div><input type="submit" /></div>
</form>

</body>
</html>

<!--{
"address":"1N7hN3hqj6UXAejaZ9HFhmFYVwJJ1Hvn3c",
"signature":"IEiQ0KTRQ81M3Kh9ljxJAInngTb+4PnAvCOuwFceliBRZ9mOecSmrAA6GuQm5fb59Yz0bVrY10To5X4XSgKbifw=",
"uri":"bitid://192.168.1.67:8888/authenticate?x=f19531c7fcd45646208df0457ce10987434ef10ebadcca1394bdf2dd56eb852a&u=1"}-->