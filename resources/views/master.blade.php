<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">

        <title>MyProtfolio</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
          @font-face {
            font-family: "rushink";
            src: url("rushink.ttf")format("ttf");
            src: url("rd.otf")format("otf");
        }
        
        @font-face {
            font-family: "boughiesdemo";
            src: url("boughiesdemo.ttf");
            src: url("boughiesdemo.ttf") format("ttf");
        }
        
        @import url('https://fonts.googleapis.com/css?family=Poppins:700&display=swap');
        .bgimage {
            background: url('{{URL::asset('/img/bg.jpg')}}');
            background-position: center center;
            background-size: cover;
            height: 200px;
            font-size: 300%;
            color: white;
            text-align: center;
            padding: 60px;
            font-family: 'Rushink DEMO Bold';
        }
        
        .myimg {
            height: 160px;
            width: 160px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .mycustomimg {
            height: 300px;
            width:300px;
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
        .simplemargin {
            margin-left: 150px;
            margin-right: 150px;
             margin-top: 20px;
        }
        .large{
            width: 80%;
            text-align: center;
            margin:10px;
        }
        .maxlength {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}

.alert{padding: 20px; transition:all .3s ease;}
.alert:hover, .alert:focus{transform:scale(1.04); -webkit-box-shadow: 0 8px 20px #e8e8e8;box-shadow: 0 8px 20px #e8e8e8;}
.alert-wrap { width:80%;  margin:50px auto 0;}
.alert .close{opacity:0; transition:opacity .3s ease;}
.alert:hover .close, .alert:focus .close{opacity:.2;}
.alert i{min-width:30px; text-align:center;}
.alert-success{background: rgb(214,233,198);background: linear-gradient(0deg, rgba(214,233,198,1) 0%, rgba(198,233,229,1) 100%);}



.alert-danger{background: rgb(235,204,209);background: linear-gradient(0deg, rgba(235,204,209,1) 0%, rgba(235,204,221,0.927608543417367) 100%);}
        </style>
  
    </head>
    <body>
@yield('content')
    </body>
</html>