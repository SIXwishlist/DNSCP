<div class="page-header">
    <h2><i class="fa fa-tachometer" aria-hidden="true"></i> {{ _("index_dashboard") }}</h2>
</div>


<div class="well">
    <h3>{{ _("index_welcome") }}</h3>
</div>
<hr>

{%- macro dashboardPanel(icon,count,title,link) %}
<div class="col-lg-3 col-sm-6 col-xs-12">
    <a href="{{ link }}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa {{ icon }} fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ count }}</div>
                        <div>{{ title }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">{{ _("index_view_details") }}</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </a>
</div>
{%- endmacro %}

{% if permissions.checkPermission('dns','general') %}
    {{ dashboardPanel('fa-map-signs',count_dns,_("dnszones_title"),'/dns/slidedata') }}
{% endif %}
{{ dashboardPanel('fa-file-pdf-o','',_("index_pdfsummary_text"),'/index/PDFSummary/'~session.get('auth')['customers_id']) }}