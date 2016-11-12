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
                <th class="text-center">{$lang["Name"]}</th>
                <th class="text-center">{$lang["Email"]}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$php.check item=row}
                <tr class="bg-warning">
                    <td class="text-center"><a href="/user/confirm/status=1/for_user_id={$row.id}" class="btn btn-info">{$row.id}</a></td>
                    <td class="text-left">{$row.name}</td>
                    <td class="text-left">{$row.email}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/if}
</div>

{include file="tail.tpl"}