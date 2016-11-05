{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["List of all Drivers"]}</h3>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-primary">
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">Info</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
{foreach from=$php.list item=row}
            <tr class="{if $row.status == 1}bg-warning{else}bg-success{/if}">
                <td class="text-center"><a href="/driver/info/driver_id={$row.id}" class="btn btn-info">{$row.id}</a></td>
                <td class="text-left">{$row.last_name} {$row.first_name} {$row.father_name}</td>
                <td class="text-left">{$row.info}</td>
                <td class="text-center">{$lang["status`$row.status`"]}</td>
            </tr>
{/foreach}
        </tbody>
    </table>
</div>

{include file="tail.tpl"}