{include file="head.tpl"}

<div class="container">

{if $php.driver_id == ""}
    <script> document.location = "/driver/list"; </script>
{else}

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"
                ><strong>{$php.driver_name}</strong> - {$lang["Driver's documents"]}</h3>
        </div>
    </div>

    {if $php.count == 0}
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{$lang["There are no documents."]}</h3>
                </div>
            </div>
        </div>
    {else}
        <table class="table table-bordered table-hover table-striped">
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
                    <td class="text-center"
                        ><a href="{$php.docs_web}{$row.filename}" class="btn btn-info" target="_blank">{$row.id}</a></td>
                    <td class="text-left">
                        <a href="{$php.docs_web}{$row.filename}" target="_blank"><tt>{$row.filename}</tt></a></td>
                    <td class="text-left">{$row.info}</td>
                    <td class="text-center"><a href="/docs/drop/doc_id={$row.id}" class="btn btn-danger"
                        onclick="return confirm('{$lang["Are you really want to delete this document?"]}');"
                        ><i class="glyphicon glyphicon-remove"></i></a></td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/if}

    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Upload document"]}</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="/docs/upload/driver_id={$php.driver_id}" enctype="multipart/form-data">
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
                        <div class="col-md-2 text-left">
                            <button type="submit" class="btn btn-warning" title="{$lang["Upload File"]}" />
                              <i class="glyphicon glyphicon-upload"></i>&nbsp&nbsp{$lang["Upload File"]}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
{/if}

</div>

{include file="tail.tpl"}