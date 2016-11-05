{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Login existing user"]}</h3>
        </div>
        <div class="panel-body">
{if $php.logged}
            {$lang["You are logged in"]}
            <script>
                setTimeout(function(){ document.location = '/driver/find'; }, 1500);
            </script>
{else}
            {if $php.error}
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">{$php.error}</h3>
                    </div>
                </div>
            {/if}
            <form method="post">
                {$lang["E-mail:"]}
                <input type="text" name="email" class="form-control" value="{$php.user.email}" />
                <br>
                {$lang["Password:"]}
                <input type="password" name="password" class="form-control"  value="" />
                <br>
                <input type="submit" value="{$lang["Login"]}" class="btn btn-primary" />
            </form>
{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}