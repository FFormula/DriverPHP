{include file="head.tpl"}

<div class="container">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Driver's documents"]}</h3>
        </div>
        <div class="panel-body">

            {if $php.count == 0}
                {$lang["There are no documents."]}
            {else}
                {foreach from=$php.list item=row}
                    {$row.id}. <a href="{$row.filename}"
                >{if $row.info}$row.info{else}untitled{/if}</a><br>
                {/foreach}
            {/if}
            <br><br>
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
                        <div class="col-md-2 text-left"><input type="submit" class="btn btn-warning" value="{$lang["Upload File"]}" /></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{include file="tail.tpl"}