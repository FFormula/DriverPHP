{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Document upload results</h3>
        </div>
    </div>

{if $php.error}
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">{$php.error}</h3>
        </div>
    </div>
    <a href="/driver/list" class="btn btn-info">{$lang["Return"]}</a>
{else}

{/if}

</div>

{include file="tail.tpl"}