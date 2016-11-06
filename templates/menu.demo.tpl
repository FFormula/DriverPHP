<div class="container">
    <div class="row">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target="#MyTopMenu" >
                        <span class="sr-only">Open menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="MyTopMenu">
                    <ul class="nav navbar-nav">
                        <li{if $menu == "driver/find"} class="active"{/if}><a href="/driver/find" title="{$lang["FIND"]}">{$lang["FIND"]}</a></li>
                        <li{if $menu == "user/insert"} class="active"{/if}><a href="/user/insert" title="{$lang["JOIN"]}">{$lang["JOIN"]}</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li{if $menu == "user/login"} class="active"{/if}>
                            <a href="/user/login" title="{$lang["LOGIN"]}">
                                <i class="glyphicon glyphicon-log-in"></i>&nbsp&nbsp{$lang["LOGIN"]}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
