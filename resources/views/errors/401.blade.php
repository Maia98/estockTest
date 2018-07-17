<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>eStock - Engeselt</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
	    <!-- Bootstrap 3.3.6 -->
    	<link rel="stylesheet" href="{{ url('/') }}/bootstrap/css/bootstrap.min.css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }

            #voltar {
                font-weight: 100;
                font-size: 30px;
                color: #B0BEC5;
            }

            #voltar:hover{
             color: #000000;   
            }
            

        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Error 401: Voce não tem permissão suficiente para acessar está página.</div>
                <a href="{{ url('/') }}" id="voltar"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
            </div>
        </div>
    </body>
</html>
