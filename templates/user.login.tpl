{include file="head.tpl"}

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Login existing user</h3>
        </div>
        <div class="panel-body">
{if $php.logged}
            You are logged in.
            <script>
                setTimeout(function(){ document.location = '/driver/find'; }, 1500);
            </script>
{else}
            {if $php.error}
                <div>{$php.error}</div>
            {/if}
            <form method="post">
                E-mail:
                <input type="text" class="form-control" name="email" value="{$php.user.email}" />
                <br>
                Password:
                <input type="password" class="form-control" name="password" value="" />
                <br>
                <input type="submit" value="Add user" class="btn btn-primary" />
            </form>
{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}