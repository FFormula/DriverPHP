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

            <form method="post">
                Name:
                <input type="text" name="name" value="{$php.user.name}" />
                <br>
                E-mail:
                <input type="text" name="email" value="{$php.user.email}" />
                <br>
                Password:
                <input type="text" name="password" value="" />
                <br>
                <input type="submit" value="Add user" class="btn btn-primary" />
            </form>

{/if}
        </div>
    </div>
</div>

{/if}

{include file="tail.tpl"}



