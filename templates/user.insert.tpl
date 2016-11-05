{include file="head.tpl"}

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Register new User</h3>
        </div>
        <div class="panel-body">

{if $php.saved}
            You are registered, please log in.
{else}
            {if $php.error}
                <div>{$php.error}</div>
            {/if}
            <form method="post" class="col-lg-4">
                Name:
                <input type="text" name="name" class="form-control" value="{$php.user.name}" />
                <br>
                E-mail:
                <input type="text" name="email" class="form-control" value="{$php.user.email}" />
                <br>
                Password:
                <input type="text" name="password" class="form-control"  value="" />
                <br>
                <input type="submit" value="Add user" class="btn btn-primary" />

            </form>

{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}



