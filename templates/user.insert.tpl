{include file="head.tpl"}

<div class="container">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Register new User"]}</h3>
        </div>
        <div class="panel-body">

{if $php.saved}
            {$lang["You are registered, please log in"]}
{else}
            {if $php.error}
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">{$php.error}</h3>
                    </div>
                </div>
            {/if}
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">{$lang["Name:"]}</label>
                    <div class="col-md-10"><input type="text" name="name" class="form-control" value="{$php.user.name}" /></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">{$lang["E-mail:"]}</label>
                    <div class="col-md-10"><input type="text" name="email" class="form-control" value="{$php.user.email}" /></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">{$lang["Password:"]}</label>
                    <div class="col-md-10"><input type="text" name="password" class="form-control"  value="" /></div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-5 col-md-7">
                        <div class="col-md-2 text-left"><input type="submit" value="{$lang["Add user"]}" class="btn btn-warning" /></div>
                    </div>
                </div>
            </form>

{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}



