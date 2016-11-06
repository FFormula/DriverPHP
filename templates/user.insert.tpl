{include file="head.tpl"}

<div class="container" xmlns="http://www.w3.org/1999/html">
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
                        <button type="submit" title="{$lang["Add user"]}" class="btn btn-warning" />
                            <i class="glyphicon glyphicon-user"></i>&nbsp&nbsp{$lang["Add user"]}
                        </button>
                       </div>
                    </div>
                </div>
            </form>

{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}



