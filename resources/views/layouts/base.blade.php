<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap4.css')}}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
</head>

<body>
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>

    <script>
        $(".input-number_tel").mask("00");
        $(".input-phone").mask("(99) 9 9999-9999");
    </script>
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        function showImage(el) {
            console.log('entrou');
            modal.style.display = "block";
            console.log('blocou');
            var modalImg = document.getElementById("img-view");
            modalImg.src = el.src;
            console.log('imagjou');
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        document.getElementById("close").onclick = function () {
            modal.style.display = "none";
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
</body>

</html>