{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Register new User"]}</h3>
        </div>
        <div class="panel-body">

{if $php.saved}
            {$lang["You are registered, please log in"]}
{else}
            {if $php.error}
                <div>{$php.error}</div>
            {/if}
            <form method="post" class="col-lg-4">
                {$lang["Name:"]}
                <input type="text" name="name" class="form-control" value="{$php.user.name}" />
                <br>
                {$lang["E-mail:"]}
                <input type="text" name="email" class="form-control" value="{$php.user.email}" />
                <br>
                {$lang["Password:"]}
                <input type="text" name="password" class="form-control"  value="" />
                <br>
                <input type="submit" value="{$lang["Add user"]}" class="btn btn-primary" />
            </form>

{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}



