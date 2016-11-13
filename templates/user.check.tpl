{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["List of users on the verification"]}</h3>
        </div>
    {if $php.check|@count == 0}
        <div class="panel-body">
            {$lang["The list is empty"]}
        </div>
    </div>
    {else}
    </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr class="bg-primary">
                <th class="text-center">{$lang["#"]}</th>
                <th class="text-center">{$lang["Park"]}</th>
                <th class="text-center">{$lang["Name"]}</th>
                <th class="text-center">{$lang["Phone"]}</th>
                <th class="text-center">{$lang["Email"]}</th>
                <th class="text-center">{$lang["Status"]}</th>
                <th class="text-center">{$lang["Action"]}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$php.check item=row}
                <tr class="{if $row.status == 0}bg-warning{else}{if $row.status == 1}bg-success{else}bg-danger{/if}{/if}">
                    <td class="text-center">{$row.id}</td>
                    <td class="text-left">{$row.park}</td>
                    <td class="text-left">{$row.name}</td>
                    <td class="text-left">{$row.phone}</td>
                    <td class="text-left">{$row.email}</td>
                    <td class="text-center">{$lang["user_status_`$row.status`"]}</td>
                    <td class="text-center">
                    {if $row.status != 1}
                        <a href="/user/confirm/status=1/for_user_id={$row.id}" class="btn btn-success"
                            >{$lang["Confirm"]}</a>
                    {/if}
                    {if $row.status != 2}
                        <a href="/user/confirm/status=2/for_user_id={$row.id}" class="btn btn-warning"
                            >{$lang["Admin"]}</a>
                    {/if}
                    {if $row.status == 1}
                        <a href="/user/confirm/status=drop/for_user_id={$row.id}" class="btn btn-danger"
                           onclick="return confirm('{$lang["Are you really want to delete this user?"]}');"
                            ><i class="glyphicon glyphicon-remove"></i></a>
                    {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/if}
</div>

{include file="tail.tpl"}