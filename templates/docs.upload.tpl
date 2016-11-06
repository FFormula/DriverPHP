{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Document upload results</h3>
        </div>
        <div class="panel-body">

            {if $php.error}
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">{$php.error}</h3>
                    </div>
                </div>
            {else}

            {/if}

            <div class="text-center">
                <a href="/driver/list" class="btn btn-info">Return</a>
            </div>

        </div>
    </div>
</div>

{include file="tail.tpl"}