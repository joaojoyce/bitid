<html>

<body>
<form method="POST" action="{{url('authenticate')}}">
    <div>Signature: <input name="signature" type="text" /></div>
    <div>Public Key: <input name="public_key" type="text" /></div>
    <div>Nonce: <input name="nonce" type="text" /></div>
    <div><input type="submit" /></div>
</form>

</body>
</html>