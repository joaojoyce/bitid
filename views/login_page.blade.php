<html>
<body>

<div>{{$url}}</div>
<img src="{{$img_url}}" />

</body>

<script>
    (function(){
        setInterval(function(){checkLoggedIn();}, 1000);

        function checkLoggedIn() {
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open( "GET", '{{url('/check')}}', false );
            xmlHttp.send( null );
            if(xmlHttp.status == 200) {
                window.location = '/user';
            }
        }

    })();
</script>
</html>