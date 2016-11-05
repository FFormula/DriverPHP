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
            {/if}

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
    </div>
</div>

{include file="tail.tpl"}