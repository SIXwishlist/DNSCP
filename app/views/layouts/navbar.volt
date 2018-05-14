<nav class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-wrapper">
        <div class="navbar-header clearfix">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="true" aria-controls="navbar">
                <span class="sr-only">Navigation ein-/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> 
            <div class="logoWrapper">
                <a href="/index/"><img src="/img/logo_aronet.svg" width="115"></a>
            </div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <div class="headerNavText">
                {% set menuPoints = session.get('auth')['menu'] %}
                {% if menuPoints is not empty %}
                    {% include "partials/core/macros/renderMenuElements.volt" %}
                    {{ renderMenuElements(menuPoints,'Navbar') }}
                {% else %}
                    menu missing
                {% endif %}
                </div>
            
                <li id="account">
                    <a href="#" class="navbar-link dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-user-circle fa-fw"></span>&nbsp;{{ sessionLoginname }}
                    </a>
                    <ul class="dropdown-menu list-group" role="menu">
                        <li>{{ link_to('logins/profile', '<span class="fa fa-home"></span> '~_("profile_header")) }}</li>
                        <li>{{ link_to('logins/resetPasswordForm/'~sessionLoginId, '<span class="fa fa-key"></span> '~_("profile_reset_password")) }}</li>
                        <li>{{ link_to('logins/themes', '<span class="fa fa-picture-o"></span> '~_("profile_theme")) }}</li>
                        <hr>
                        <li>{{ link_to('access/logout', '<span class="fa fa-sign-out"></span> '~_("profile_logout")) }}</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>