{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Find by Name / Passport"]}</h3>
        </div>
        <div class="panel-body">
            <form method="post">
                {$lang["Name or Passport:"]}
                <input type="text" name="by" value="{$php.by}" />
                <input type="submit" class="btn btn-primary" value="{$lang["Find"]}" />
            </form>
{if $php.count}
            Search results: {$php.count}
{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}