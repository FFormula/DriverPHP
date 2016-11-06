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
                        <li{if $menu == "driver/find"} class="active"{/if}><a href="/driver/find" title="{$lang["FIND"]}">{$lang["FIND"]}</a></li>
                        <li{if $menu == "driver/list" ||
                               $menu == "driver/info"} class="active"{/if}><a href="/driver/list" title="{$lang["DRIVERS"]}">{$lang["DRIVERS"]}</a></li>
                        <li{if $menu == "driver/insert"} class="active"{/if}><a href="/driver/insert" title="{$lang["ADD NEW"]}">{$lang["ADD NEW"]}</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li{if $menu == "user/logout"} class="active"{/if}>
                            <a href="/user/logout" title="{$lang["LOGOUT"]}"
                            ><b>{$lang["user_status_`$user.status`"]} {$user.name}</b> /
                            {$lang["LOGOUT"]}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
