<div id="sidebarWrapper" class="well affix">
    <ul class="sidebar-nav nav clearfix list-group">
        <li id="toggleWrapper" class="clearfix list-group-item">
            <span id="menu-toggle" class="btn btn-primary pull-left" title="Navigation ein-/ausblenden">
                <i class="fa fa-navicon"></i>
            </span>
            <div id="sidebar-title" class="sideBarText">{{ appTitle }}</span></div>
        </li>
        {% set menuPoints = session.get('auth')['menu'] %}
        {% if menuPoints is not empty %}
            {% include "partials/core/macros/renderMenuElements.volt" %}
            {{ renderMenuElements(menuPoints,'Sidebar') }}
        {% else %}
            {{ _("menu_not_found") }}
        {% endif %}
    </ul>  
</div>