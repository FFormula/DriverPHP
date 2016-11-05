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
                        <li><a href="/driver/find" title="{$lang["FIND"]}">{$lang["FIND"]}</a></li>
                        <li><a href="/driver/list" title="{$lang["DRIVERS"]}">{$lang["DRIVERS"]}</a></li>
                        <li><a href="/driver/insert" title="{$lang["ADD NEW"]}">{$lang["ADD NEW"]}</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/user/logout" title="{$lang["LOGOUT"]}"><b>{$user.name}</b> / {$lang["LOGOUT"]}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>