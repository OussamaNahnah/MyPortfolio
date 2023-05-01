<!DOCTYPE html>
<html>

<head>
    <title>My portfolio</title>
    <meta charset="utf-8" /> 
     <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/css/kube.min.css" />
    <link rel="stylesheet" href="/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css/custom.min.css" />
 
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display+SC:700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        .intro h1:before {
            /* Edit this with your name or anything else */
            content: 'MyCv';
        }

        .myimg {
            height: 100px;
            width: 100px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }


        .margin {
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .center {
            font-family: 'Poppins';
            text-align: center;
        }



        //////////////avatar///////

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        pre {
            margin: 20px 0;
            padding: 20px;
            background: #fafafa;
        }

        .round {
            border-radius: 50%;
        }

        ////////
        .owl-carousel {
            position: relative;
        }

        .owl-next,
        .owl-prev {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
        }

        .owl-next {
            right: 0;
            display: flex;
        }

        .owl-prev {
            left: 0;
            display: flex;
        }

        .i-am-centered {
            margin: auto;
            width: 50%; 
            padding: 10px;
        }
        a:link {
            color: #6D5D6E;
        }

        /* visited link */
        a:visited {
            color: #6D5D6E;
        }

        /* mouse over link */
        a:hover {
            color: #393646;
        }

        /* selected link */
        a:active {
            color: #6D5D6E;
        }
    </style>


</head>

<body>

    <!-- Navigation -->
    <div class="main-nav">
        <div class="container">
            <header class="group top-nav">
                <div class="navigation-toggle" data-tools="navigation-toggle" data-target="#navbar-1">
                    <span class="logo">Users</span>
                </div>
                <nav id="navbar-1" class="navbar item-nav">
                    <ul>
                        <li><a href="{{ route('index') }}">Users</a></li>
                        <li><a href="{{ route('admin') }}">Dashboard</a></li>
                        <li><a href="{{ route('me') }}">Contact Me</a></li>
                    </ul>
                </nav>
            </header>
        </div>
    </div>




    <div class="container">

        <div class="row justify-content-center">

            @foreach ($users as $user)
                <div class="col-sm-3 margin">
                    @if ($user->getMedia('image')->count() != null)
                        <img src="  {{ $user->getFirstMediaUrl('image') }} " class="img-circle myimg"
                            alt="cinque terre">
                    @else
                        <img avatar="{{ $user->fullname }}" class="img-circle myimg" alt="cinque terre">
                    @endif

                    <section>
                        <h4 class="center"> {{ $user->fullname }}</h4>
                        <!--p class="center maxlength"> {{ '@' . $user->username }} </p-->
                        <center> <a href="{{ route('user', [$user->id]) }}">Read More...</a></center>
                        <center> <a href="{{ route('cv', [$user->id]) }}">Download CV</a></center>
      
                    </section>

                </div>
            @endforeach

        </div>

        <div class="i-am-centered">
            <div class="row i-am-centered"> {{ $users->links() }}</div>
        </div>


    </div>






    <script>
        /*
         * LetterAvatar
         * 
         * Artur Heinze
         * Create Letter avatar based on Initials
         * based on https://gist.github.com/leecrossley/6027780
         */
        (function(w, d) {


            function LetterAvatar(name, size) {

                name = name || '';
                size = size || 60;

                var colours = [
                        "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9",
                        "#8e44ad", "#2c3e50",
                        "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b",
                        "#bdc3c7", "#7f8c8d"
                    ],

                    nameSplit = String(name).toUpperCase().split(' '),
                    initials, charIndex, colourIndex, canvas, context, dataURI;


                if (nameSplit.length == 1) {
                    initials = nameSplit[0] ? nameSplit[0].charAt(0) : '?';
                } else {
                    initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
                }

                if (w.devicePixelRatio) {
                    size = (size * w.devicePixelRatio);
                }

                charIndex = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
                colourIndex = charIndex % 20;
                canvas = d.createElement('canvas');
                canvas.width = size;
                canvas.height = size;
                context = canvas.getContext("2d");

                context.fillStyle = colours[colourIndex - 1];
                context.fillRect(0, 0, canvas.width, canvas.height);
                context.font = Math.round(canvas.width / 2) + "px Arial";
                context.textAlign = "center";
                context.fillStyle = "#FFF";
                context.fillText(initials, size / 2, size / 1.5);

                dataURI = canvas.toDataURL();
                canvas = null;

                return dataURI;
            }

            LetterAvatar.transform = function() {

                Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
                    name = img.getAttribute('avatar');
                    img.src = LetterAvatar(name, img.getAttribute('width'));
                    img.removeAttribute('avatar');
                    img.setAttribute('alt', name);
                });
            };


            // AMD support
            if (typeof define === 'function' && define.amd) {

                define(function() {
                    return LetterAvatar;
                });

                // CommonJS and Node.js module support.
            } else if (typeof exports !== 'undefined') {

                // Support Node.js specific `module.exports` (which can be a function)
                if (typeof module != 'undefined' && module.exports) {
                    exports = module.exports = LetterAvatar;
                }

                // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
                exports.LetterAvatar = LetterAvatar;

            } else {

                window.LetterAvatar = LetterAvatar;

                d.addEventListener('DOMContentLoaded', function(event) {
                    LetterAvatar.transform();
                });
            }

        })(window, document);
    </script>
</body>

</html>
