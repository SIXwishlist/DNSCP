<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>
            {% block title %}{{ appTitle }}
                {% if pageTitle is defined %}
                    &bull; {{ pageTitle }}
                {% endif %}
            {% endblock %}
        </title>
        <meta name="apple-mobile-web-app-title" content="{{ appTitle }}">
        <meta name="description" content="">
        <meta name="author" content="">
        
        {% block head %}
            {# css includes #}
            {{ stylesheet_link("/css/style.css") }}
        {% endblock %}
        
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
        <style>
            body { padding-top: 70px;}

            /* Background Image */
            html{
              height: 100%;
            }
            body {
                position: relative;
                background-size: 100% 100%;
                background-repeat: no-repeat;
                min-height: 100%;
                background-image: linear-gradient(#d7eaff, #4D8DD3);
            }
            body::after {
              content: "";
              background: url('/img/background.jpg') no-repeat center center;
              background-size:cover;
              opacity: 0.4;
              top: 0;
              left: 0;
              bottom: 0;
              right: 0;
              position: absolute;
              z-index: -1;  
              -webkit-filter: grayscale(0.5);
              filter: grayscale(0.5);
            }
            .panel-heading {
                background-color: #004086 !important;
            }
            
            .panel {
                border-color: rgba(26, 90, 160, 0.9) !important;
            }
            
            .btn {
                background-color: #004086 !important;
                border-color: #004086 !important;
            } 
            
            .form-group .input-group-addon {
                color: #c20049 !important;
            }
            a.btn-default {
                color: white !important;
            }
            
            .panel-body h4 {
                margin-bottom: 15px;
            }
            
            .logoWrapper {
                margin: 0 auto;
                width: 180px;
            }
        </style>
        
        <!-- FAVICONS -->
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

    </head>
    <body>
        <div class="container">
            <div id="main" role="main">
                <div id="content">
                    {% block main %}{% endblock %}
                </div>
            </div>
        </div>
    </body>
</html>