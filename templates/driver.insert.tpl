{include file="head.tpl"}

<div class="container">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Register new Driver"]}</h3>
        </div>
        <div class="panel-body">

            {if $php.saved}
                {$lang["Driver added."]}
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
                        <label class="col-md-2 control-label">{$lang["Last name:"]}</label>
                        <div class="col-md-10"><input type="text" class="form-control" name="last_name" value="{$php.driver.last_name}" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{$lang["First name:"]}</label>
                        <div class="col-md-10"><input type="text" class="form-control" name="first_name" value="{$php.driver.first_name}" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{$lang["Father name:"]}</label>
                        <div class="col-md-10"><input type="text" class="form-control" name="father_name" value="{$php.driver.father_name}" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{$lang["Passport serial:"]}</label>
                        <div class="col-md-10"><input type="text" class="form-control" name="passport_serial" value="{$php.driver.passport_serial}" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{$lang["Passport number:"]}</label>
                        <div class="col-md-10"><input type="text" class="form-control" name="passport_number" value="{$php.driver.passport_number}" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{$lang["Info:"]}</label>
                        <div class="col-md-10"><input type="text" class="form-control" name="info" value="{$php.driver.info}" /></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-7">
                            <div class="col-md-2 text-left"><input type="submit" value="{$lang["Add driver"]}" class="btn btn-warning" /></div>
                        </div>
                    </div>
                </form>

            {/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}



