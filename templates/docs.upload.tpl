{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Document upload results"]}</h3>
        </div>
        <div class="panel-body">

            {if $php.error}
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">{$php.error}</h3>
                    </div>
                </div>
            {else}
                {$lang["Document uploaded successfully"]}
            {/if}

            <div class="text-center">
                <a href="/docs/list/driver_id={$php.driver_id}" class="btn btn-info"
                ><i class="glyphicon glyphicon-open"></i>&nbsp&nbsp{$lang["Return"]}</a>
            </div>

        </div>
    </div>
</div>

{include file="tail.tpl"}