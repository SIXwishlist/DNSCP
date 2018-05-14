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

        <!-- Bootstrap https://www.bootstrapcdn.com/ -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        {% if sessionTheme is not empty AND sessionTheme != 'default' %}<link href="https://bootswatch.com/{{ sessionTheme }}/bootstrap.css" rel="stylesheet" name="bootswatch">{% endif %}
        
        {% block head %}
            {# css includes #}
            {{ stylesheet_link("/css/navbar.css") }}
            {{ stylesheet_link("/css/style.css") }}
            {{ stylesheet_link("/css/bootcomplete.css") }}
            {% if sessionTheme == 'default' %}
                {{ stylesheet_link("/css/bootstrap.min.css") }}
                {{ stylesheet_link("/css/bootstrap-theme.min.css") }}
            {% endif %}
        {% endblock %}
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        
        <!-- Bootstrap Select -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        
        <!-- Bootstrap Datepicker -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/css/bootstrap-datepicker.min.css" integrity="sha256-V0Nho4sjvYsznAMBVSBq2YuaQ8CDXv4FRdoIy+Yf4zk=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha256-nANdi1cA3v/RP9GPWWiZha3cNljtzAxDncp+A1LLmT4=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/js/bootstrap-datepicker.min.js" integrity="sha256-FOV0q1Ks/eXoUwtkcN6OxWV4u9OSq7LDomNYnfF/0Ys=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/locales/bootstrap-datepicker.de.min.js" integrity="sha256-MRg0FdDDqvQkQ3VIUMZCZ39M6O40kpoIYqCGU2rRyxE=" crossorigin="anonymous"></script>
        
        <!-- Fixed Top Menue -->
        <style>body { padding-top: 70px;}</style>        
        
        <!-- FAVICONS -->
        <link rel="shortcut icon" href="/img/favicon.png" type="image/x-png">
        <link rel="icon" href="/img/favicon.png" type="image/png">
                                                                      
    </head>
    <body>
        <div id="loadingScreen" class="loaderBackground">
            <div class="spinnerWrapper">
                <div class="spinner">
                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    <div class="loaderText">Loading ...</div><br /><br />
                </div>
            </div>
        </div>
        <div id="body" style="display: none;">
            <div id="pageWrapper" {% if sidebarToggled=="true" %}class="toggled"{% endif %}>
                {# Header #}
                {% include "layouts/navbar.volt" %}
            
                {# Left navigation #}
                {% include "layouts/sidebar.volt" %}

                <div class="col-lg-12 col-md-12 col-xs-12 container page-content-wrapper">
                    {# Flash Message #}
                    {{ flashSession.output() }}
                    {{ flash.output() }}

                    {% block content %}{% endblock %}
                </div>

                {# javascript includes #}
                {{ javascript_include("/js/navbar.js") }}
                {{ javascript_include("/js/tableslidedata.js") }}
                {{ javascript_include("/js/loadingScreen.js") }}
                {{ javascript_include("/js/genPassword.js") }}
                {{ javascript_include("/js/jquery.bootcomplete.js") }}
                {% block jsfooter %}{% endblock %}
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#body').show();
                $('#loadingScreen').hide();
            });
        </script>
    </body>
</html>