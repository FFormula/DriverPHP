{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Document dropping results"]}</h3>
        </div>
        <div class="panel-body">

            {if $php.error}
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">{$php.error}</h3>
                    </div>
                </div>
            {else}
                {$lang["Document dropped successfully"]}
            {/if}

            <div class="text-center">
            {if $php.driver_id}
                <a href="/docs/list/driver_id={$php.driver_id}" class="btn btn-info">{$lang["Return"]}</a>
            {else}
                <a href="/driver/list" class="btn btn-info">{$lang["Return"]}</a>
            {/if}
            </div>

        </div>
    </div>
</div>

{include file="tail.tpl"}