{include file="head.tpl"}

<div class="container">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Register new User"]}</h3>
        </div>
        <form class="form-horizontal" method="post">
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
                <div class="form-group{if $php.warn.park} has-error has-feedback{/if}">
                    <label class="col-md-2 control-label">{$lang["Park:"]}</label>
                    <div class="col-md-10"><input type="text" name="park" class="form-control" value="{$php.user.park}" /></div>
                </div>
                <div class="form-group{if $php.warn.phone} has-error has-feedback{/if}">
                    <label class="col-md-2 control-label">{$lang["Phone:"]}</label>
                    <div class="col-md-10"><input type="text" name="phone" class="form-control" value="{$php.user.phone}" /></div>
                </div>
                <div class="form-group{if $php.warn.name} has-error has-feedback{/if}">
                    <label class="col-md-2 control-label">{$lang["Name:"]}</label>
                    <div class="col-md-10"><input type="text" name="name" class="form-control" value="{$php.user.name}" /></div>
                </div>
        </div>
        <div class="panel-body bg-warning">
                <div class="form-group{if $php.warn.email} has-error has-feedback{/if}">
                    <label class="col-md-2 control-label">{$lang["E-mail:"]}</label>
                    <div class="col-md-10"><input type="text" name="email" class="form-control" value="{$php.user.email}" /></div>
                </div>
                <div class="form-group{if $php.warn.password} has-error has-feedback{/if}">
                    <label class="col-md-2 control-label">{$lang["Password:"]}</label>
                    <div class="col-md-10"><input type="text" name="password" class="form-control"  value="{$php.user.password}" /></div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-5 col-md-7">
                        <div class="col-md-2 text-center">
                            <button type="submit" title="{$lang["Add user"]}" class="btn btn-primary" />
                                <i class="glyphicon glyphicon-user"></i>&nbsp&nbsp{$lang["Add user"]}
                            </button>
                        </div>
                    </div>
                </div>

{/if}
        </div>
        </form>
    </div>
</div>

{include file="tail.tpl"}



