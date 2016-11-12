<div class="container">
    <div class="row">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target="#MyTopMenu" >
                    <span class="sr-only">Open menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="container">
                <div class="collapse navbar-collapse" id="MyTopMenu">
                    <ul class="nav navbar-nav">
                        <li{if $menu == "driver/find"} class="active"{/if}>
                            <a href="/driver/find" title="{$lang["FIND"]}">
                                <i class="glyphicon glyphicon-search"></i>&nbsp&nbsp{$lang["FIND"]}
                            </a>
                        </li>
                        <li{if $menu == "driver/list"} class="active"{/if}>
                            <a href="/driver/list" title="{$lang["DRIVERS_CONFIRMED"]}">
                                <i class="glyphicon glyphicon-briefcase"></i>&nbsp&nbsp{$lang["DRIVERS_CONFIRMED"]}
                                {if isset($php.list) && $php.list|@count > 0}
                                    <span class="badge">{$php.list|@count}</span>
                                {/if}
                            </a>
                        </li>
                        <li{if $menu == "driver/wait"} class="active"{/if}>
                            <a href="/driver/wait" title="{$lang["DRIVERS_ON_CHECK"]}">
                                <i class="glyphicon glyphicon-briefcase"></i>&nbsp&nbsp{$lang["DRIVERS_ON_CHECK"]}
                                {if isset($php.wait) && $php.wait|@count > 0}
                                    <span class="badge">{$php.wait|@count}</span>
                                {/if}
                            </a>
                        </li>
                        <li{if $menu == "driver/insert"} class="active"{/if}>
                            <a href="/driver/insert" title="{$lang["ADD NEW"]}">
                                <i class="glyphicon glyphicon-plus"></i>&nbsp&nbsp{$lang["ADD NEW"]}
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li{if $menu == "user/check"} class="active"{/if}>
                            <a href="/user/check"><b><i class="glyphicon glyphicon-user"></i>&nbsp&nbsp{$lang["user_status_`$user.status`"]} / {$user.name}</b></a>
                        </li>
                        <li{if $menu == "user/logout"} class="active"{/if}>
                            <a href="/user/logout" title="{$lang["LOGOUT"]}"
                                ><i class="glyphicon glyphicon-log-out"></i>&nbsp&nbsp{$lang["LOGOUT"]}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
