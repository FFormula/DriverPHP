{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Find by Name / Passport"]}</h3>
        </div>
        <div class="panel-body">
            {if $user.id}
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label class="col-md-5 control-label">{$lang["Name or Passport:"]}</label>
                        <div class="col-md-7"><input class="form-control" type="text" name="by" value="{$php.by}" /></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-7">
                            <div class="col-md-2 text-center">
                                <button type="submit" class="btn btn-primary" title="{$lang["Find"]}" />
                                    <i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;{$lang["Find"]}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            {else}
                {$lang["You are not logged in"]}
            {/if}
        </div>
    </div>

    {if $user.id && $php.by != ""}
        {if $php.count}

            <table class="table table-bordered table-hover">
                <thead>
                <tr class="bg-primary">
                    <th class="text-center">{$lang["#"]}</th>
                    <th class="text-center">{$lang["Name"]}</th>
                    <th class="text-center">{$lang["Info"]}</th>
                    <th class="text-center">{$lang["Action"]}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$php.list item=row}
                    <tr>
                        <td class="text-center">{$row.id}</td>
                        <td class="text-left">{$row.last_name} {$row.first_name} {$row.father_name}</td>
                        <td class="text-left">{$row.info}</td>
                        <td class="text-center"><a href="/driver/info/driver_id={$row.id}/code={$row.code}" class="btn btn-info" target="_blank">{$lang["open card"]}</a></td>
                    </tr>
                {/foreach}
                </tbody>
            </table>

        {else}
            <div class="alert alert-danger">
                <strong>{$lang["No items found"]}</strong>
            </div>
        {/if}
    {/if}

</div>

{include file="tail.tpl"}