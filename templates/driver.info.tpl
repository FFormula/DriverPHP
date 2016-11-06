{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Information about Driver"]}</h3>
        </div>
        <div class="panel-body">

{if $php.error}
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">{$php.error}</h3>
                </div>
            </div>
            <a href="/driver/list" class="btn btn-info">{$lang["Return"]}</a>
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
                <div class="col-xs-6 col-md-4">
                    {if $user.status >= 2}
                        {if $php.info.status == 1}
                            <div class="text-center">
                                <a href="/driver/confirm/driver_id={$php.info.id}/status=2" class="btn btn-success"
                                >{$lang["Confirm"]}</a>
                            </div>
                            <br/>
                        {else}
                            <div class="text-center">
                                <a href="/driver/confirm/driver_id={$php.info.id}/status=1" class="btn btn-warning"
                                >{$lang["UnConfirm"]}</a>
                            </div>
                            <br/>
                        {/if}
                    {/if}
                    <div class="text-center">
                        <a href="/driver/confirm/driver_id={$php.info.id}/status=drop" class="btn btn-danger"
                           onclick="return confirm('{$lang["Do you really want to delete this record?"]}');"
                        >{$lang["Delete"]}</a>
                    </div>
                    <br/>
                </div>
            </div>

            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">{$lang["Driver's documents"]}</h3>
                </div>
                <div class="panel-body">
                     {$lang["There are no documents."]}
                    <br><br>
                    <form class="form-horizontal" method="post" action="/docs/upload/driver_id={$php.info.id}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-md-2 control-label">{$lang["Select file to upload:"]}</label>
                            <div class="col-md-10"><input type="file" name="docfile" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{$lang["File description:"]}</label>
                            <div class="col-md-10"><input type="text" name="info" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-5 col-md-7">
                                <div class="col-md-2 text-left"><input type="submit" class="btn btn-warning" value="Upload File" /></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

{/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}