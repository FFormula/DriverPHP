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
                        <dt>{$lang["Park:"]}</dt>
                        <dd>{$php.info.park} / {$php.info.user_name}</dd>
                        <dt>{$lang["Added"]}:</dt>
                        <dd>{$php.info.insert_date}</dd>
                        <dt>{$lang["Updated"]}:</dt>
                        <dd>{$php.info.update_date}</dd>
                    </dl>

                <div class="panel-body bg-info">
                    <br>
                    <dl class="dl-horizontal">
                        <dt>{$lang["Last name:"]}</dt>
                        <dd>{$php.info.last_name}</dd>
                        <dt>{$lang["First name:"]}</dt>
                        <dd>{$php.info.first_name}</dd>
                        <dt>{$lang["Father name:"]}</dt>
                        <dd>{$php.info.father_name}</dd>
                        <br/>
                        <dt>{$lang["Phone:"]}</dt>
                        <dd>{$php.info.phone}</dd>
                        <dt>{$lang["Info:"]}</dt>
                        <dd>{$php.info.info}</dd>
                    </dl>
                </div>

                    <br>
                    <dl class="dl-horizontal">
                        <dt>{$lang["Documents:"]}</dt>
                        <dd>&nbsp;</dd>
                        <dt>{$lang["Passport:"]}</dt>
                        <dd>{$php.info.passport_number}</dd>
                        <dt>{$lang["License:"]}</dt>
                        <dd>{$php.info.license_number}</dd>
                {foreach from=$php.docs item=row}
                        <dt>{$lang["File:"]}</dt>
                        <dd><a href="{$php.docs_web}{$row.filename}"><u>{$row.info}</u></a></dd>
                {/foreach}
                    </dl>

                </div>
            {if !$hide_menu}
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
                    {/if}
                    <div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <a href="/driver/insert/driver_id={$php.info.id}" class="btn btn-default"
                        ><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;{$lang["Edit"]}</a>
                        <br>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <a href="/docs/list/driver_id={$php.info.id}" class="btn btn-info"
                        ><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;{$lang["Documents"]}</a>
                        <br>
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