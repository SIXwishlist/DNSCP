{% extends "layouts/base.volt" %}

{% block content %}
<div class="jumbotron">
    <h1>Unauthorized</h1>
    <p>You don't have access to this option.<br />Contact an administrator</p>
    <p>{{ link_to('index', 'Home', 'class': 'btn btn-primary') }}</p>
</div>
{% endblock %}