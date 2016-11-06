{include file="head.tpl"}

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{$lang["Find by Name / Passport"]}</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-md-5 control-label">{$lang["Name or Passport:"]}</label>
                    <div class="col-md-7"><input class="form-control" type="text" name="by" value="{$php.by}" /></div>

                </div>
                <div class="form-group">
                    <div class="col-md-offset-5 col-md-7">
                        <div class="col-md-2 text-center">
                            <button type="submit" class="btn btn-primary" title="{$lang["Find"]}" />
                                  <i class="glyphicon glyphicon-search"></i>&nbsp&nbsp{$lang["Find"]}
                            </button></div>
                    </div>
                </div>
            </form>
    {if $php.by != ""}
        {if $php.count}
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert"><i class="glyphicon glyphicon-hand-left"></i> </button>

                <dl class="dl-horizontal">
                    <dt>{$lang["Results found:"]}</dt>
                    <dd>{$php.count}</dd>
                    
               {if $php.driver_name}
                        <dt>{$lang["Driver name:"]}</dt>
                        <dd>{$php.driver_name}</dd>
                {/if}
                </dl>
            </div>
        {else}
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"><i class="glyphicon glyphicon-hand-left"></i> </button>
                <strong>{$lang["No items found"]}</strong>
            </div>

        {/if}

    {/if}
        </div>
    </div>
</div>

{include file="tail.tpl"}