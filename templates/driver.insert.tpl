{include file="head.tpl"}

<div class="container">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">
                {if $php.driver_id}
                    {$lang["Update Driver"]}
                {else}
                    {$lang["Register new Driver"]}
                {/if}
            </h3>
        </div>
        <div class="panel-body">

            {if $php.saved}
                {$lang["Driver added."]}
                <br><br>
                <a href="/driver/info/driver_id={$php.driver_id}" class="btn btn-info"
                    ><i class="glyphicon glyphicon-open-file"></i>&nbsp&nbsp{$lang["Open card"]}</a>
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
                        <label class="col-md-2 control-label">{$lang["Driver ID:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="driver_id" value="{$php.driver_id}" readonly />
                        </div>
                    </div>
                    <div class="form-group{if $php.warn.last_name} has-error has-feedback{/if}">
                        <label class="col-md-2 control-label">{$lang["Last name:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="last_name" value="{$php.driver.last_name}" />
                            {if $php.warn.last_name}<span class="glyphicon glyphicon-remove form-control-feedback"></span>{/if}
                        </div>
                    </div>
                    <div class="form-group{if $php.warn.first_name} has-error has-feedback{/if}">
                        <label class="col-md-2 control-label">{$lang["First name:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="first_name" value="{$php.driver.first_name}" />
                            {if $php.warn.first_name}<span class="glyphicon glyphicon-remove form-control-feedback"></span>{/if}
                        </div>
                    </div>
                    <div class="form-group{if $php.warn.father_name} has-error has-feedback{/if}">
                        <label class="col-md-2 control-label">{$lang["Father name:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="father_name" value="{$php.driver.father_name}" />
                            {if $php.warn.father_name}<span class="glyphicon glyphicon-remove form-control-feedback"></span>{/if}
                        </div>
                    </div>
                    <div class="form-group{if $php.warn.passport_serial} has-error has-feedback{/if}">
                        <label class="col-md-2 control-label">{$lang["Passport serial:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="passport_serial" value="{$php.driver.passport_serial}" />
                            {if $php.warn.passport_serial}<span class="glyphicon glyphicon-remove form-control-feedback"></span>{/if}
                        </div>
                    </div>
                    <div class="form-group{if $php.warn.passport_number} has-error has-feedback{/if}">
                        <label class="col-md-2 control-label">{$lang["Passport number:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="passport_number" value="{$php.driver.passport_number}" />
                            {if $php.warn.passport_number}<span class="glyphicon glyphicon-remove form-control-feedback"></span>{/if}
                        </div>
                    </div>
                    <div class="form-group{if $php.warn.info} has-error has-feedback{/if}">
                        <label class="col-md-2 control-label">{$lang["Info:"]}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="info" value="{$php.driver.info}" />
                            {if $php.warn.info}<span class="glyphicon glyphicon-remove form-control-feedback"></span>{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-7">
                            <div class="col-md-2 text-left">
                                <button type="submit" title="{$lang["Add driver"]}" class="btn btn-warning" />
                                  <i class="glyphicon glyphicon-plus"></i>&nbsp&nbsp{$lang["Add driver"]}
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



