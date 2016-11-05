{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["List of all Drivers"]}</h3>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <tr class="bg-primary">
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Info</th>
            <th class="text-center">Status</th>
        </tr>
{foreach from=$php.list item=row}
        <tr>
            <td class="text-center">{$row.id}</td>
            <td class="text-left">{$row.last_name} {$row.first_name} {$row.father_name}</td>
            <td class="text-left">{$row.info}</td>
            <td class="text-center">{$row.status}</td>
        </tr>
{/foreach}
    </table>
</div>

{include file="tail.tpl"}