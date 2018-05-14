<div class="page-header">
    <h2><i class="fa fa-cog" aria-hidden="true"></i> Administration</h2>
</div>

<div class="well well">
    <h2>{{_("index_inventory")}}</h2>
    <p>{{_("index_inventory_teaser")}}</p>
    {{ link_to("administration/scanAllVS/",'Start','class': 'btn btn-primary') }}
</div>

{{ partial("partials/core/administration/index") }}

<div class="well">
    <h2>Faker</h2>
    {{ link_to("administration/faker/",'Fake rnt-forest user','class': 'btn btn-primary') }}
    {{ link_to("administration/fakeCustomers/",'Fake Customers','class': 'btn btn-primary') }}
    {{ link_to("administration/fakePartners/",'Fake Partners','class': 'btn btn-primary') }}
    {{ link_to("administration/fakeLogins/",'Fake Logins','class': 'btn btn-primary') }}
</div>