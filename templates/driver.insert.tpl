{include file="head.tpl"}

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Register new User</h3>
        </div>
        <div class="panel-body">

            {if $php.saved}
                Driver added.
            {else}
                {if $php.error}
                    <div>{$php.error}</div>
                {/if}
                <form method="post">
                    Last name:
                    <input type="text" name="last_name" value="{$php.driver.last_name}" />
                    <br>
                    First name:
                    <input type="text" name="first_name" value="{$php.driver.first_name}" />
                    <br>
                    Father name:
                    <input type="text" name="father_name" value="{$php.driver.father_name}" />
                    <br>
                    Passport serial:
                    <input type="text" name="passport_serial" value="{$php.driver.passport_serial}" />
                    <br>
                    Passport number:
                    <input type="text" name="passport_number" value="{$php.driver.passport_number}" />
                    <br>
                    Info:
                    <input type="text" name="info" value="{$php.driver.info}" />
                    <br>
                    <input type="submit" value="Add user" class="btn btn-primary" />
                </form>

            {/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}



