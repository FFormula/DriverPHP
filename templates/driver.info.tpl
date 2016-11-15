{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Information about Driver"]}</h3>
        </div>
        <div class="panel-body{if $php.info.status == 1} bg-danger{/if}">

{if $php.error}
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">{$php.error}</h3>
                </div>
            </div>
            <a href="/driver/list" class="btn btn-info"
            ><i class="glyphicon glyphicon-open"></i>&nbsp;&nbsp;{$lang["Return"]}</a>
{else}
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8">
                    <dl class="dl-horizontal">
                        <dt>{$lang["ID:"]}</dt>
                        <dd>{$php.info.id}</dd>
                        <dt>{$lang["Status:"]}</dt>
                        <dd>{$php.info.status_text}</dd>
                        <dt>{$lang["Owner"]}:</dt>
                        <dd>{$php.info.user_name}</dd>
                        <dt>{$lang["Added"]}:</dt>
                        <dd>{$php.info.insert_date}</dd>
                        <dt>{$lang["Updated"]}:</dt>
                        <dd>{$php.info.update_date}</dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>{$lang["Last name:"]}</dt>
                        <dd>{$php.info.last_name}</dd>
                        <dt>{$lang["First name:"]}</dt>
                        <dd>{$php.info.first_name}</dd>
                        <dt>{$lang["Father name:"]}</dt>
                        <dd>{$php.info.father_name}</dd>
                    </dl>

                    <br>

                    <dl class="dl-horizontal">
                        <dt>{$lang["Passport serial:"]}</dt>
                        <dd>{$php.info.passport_serial}</dd>
                        <dt>{$lang["Passport number:"]}</dt>
                        <dd>{$php.info.passport_number}</dd>
                    </dl>

                    <br>

                    <dl class="dl-horizontal">
                        <dt>{$lang["Info:"]}</dt>
                        <dd>{$php.info.info}</dd>
                    </dl>
                </div>
            {if !$php.code_opened}
                <div class="col-xs-6 col-md-4">
                    {if $user.status >= 2}
                        <div class="text-center">
                        {if $php.info.status == 1}
                                <a href="/driver/confirm/driver_id={$php.info.id}/status=2" class="btn btn-success"
                                ><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;{$lang["Confirm"]}</a>
                        {else}
                                <a href="/driver/confirm/driver_id={$php.info.id}/status=1" class="btn btn-warning"
                                ><i class="glyphicon glyphicon-alert"></i>&nbsp;&nbsp;{$lang["UnConfirm"]}</a>
                        {/if}
                            <a href="/driver/confirm/driver_id={$php.info.id}/status=drop" class="btn btn-danger"
                               onclick="return confirm('{$lang["Do you really want to delete this record?"]}');"
                            >&nbsp;<i class="glyphicon glyphicon-remove"></i>&nbsp;</a>
                        </div>
                        <br/>
                    {/if}
                    <div class="text-center">
                        <a href="/docs/list/driver_id={$php.info.id}" class="btn btn-info"
                        ><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;{$lang["Documents"]}</a>
                        <br>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <a href="/driver/insert/driver_id={$php.info.id}" class="btn btn-default"
                        ><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;{$lang["Edit"]}</a>
                        <br>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <br/>
                </div>
            {/if}
            </div>
{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}