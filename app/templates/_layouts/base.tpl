<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    {block 'seo'}{render_meta:raw}{/block}
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{$.assets_public_path('main.css', 'frontend')}">
    <link rel="stylesheet" href="{$.assets_public_path('root.css', 'frontend')}">
    <script>window._token = { '{$.request->csrfTokenName}':'{$.request->getCsrfToken()}' };</script>
    {block 'head'}{/block}
</head>
<body {if $.is_debug}data-debug="debug"{/if} class="{block 'body-class'}{/block}">
{set $admin = $.user && !$.user->getIsGuest()}

{block 'body'}
    {block 'header'}
        <div class="header-panel">
            <div class="container header-block">
                <a class="logo" href="/">Winter</a>
                <div class="buttons-pane">
                    {block 'controls'}
                        {if $admin}
                            <a data-action="create" class="button primary">{t 'Winter' 'Create story'}</a>
                        {else}
                        {/if}
                    {/block}
                </div>
            </div>
        </div>
    {/block}

    {block 'page'}
        <div class="container page-content">
            {block 'content'}{/block}
        </div>
    {/block}

    {block 'footer'}
        <div class="footer-panel">
            <div class="container footer-block">
                <a href="https://github.com/latur/Winter" target="_blank" class="link">Winter</a>
                {if $admin}
                    {set $drafts = $.get_drafts_count()}
                    {if $drafts > 0}
                        <a href="{url 'winter:drafts'}" class="link">{t 'Winter' 'Drafts'} ({$drafts})</a>
                    {else}
                        <span class="link">{t 'Winter' 'Drafts'}</span>
                    {/if}

                    <a href="{url 'winter:settings'}" class="link">{t 'Winter' 'Settings'}</a>
                    <a href="{url 'winter:stat'}" class="link">{t 'Winter' 'Statistics'}</a>
                    <a data-action="logout" class="link">{t 'Winter' 'Logout'}</a>
                {else}
                    <a href="{url 'winter:login'}" class="link">{t 'Winter' 'Login'}</a>
                {/if}
            </div>
        </div>
    {/block}
{/block}

{if $admin}
<script type="text/template" id="alert">
    <div data-alert class="alert">
        <div class="box">
            <p class="text">{t 'Winter' 'Blog post removed successfully'}</p>
            <a {ignore} data-action="{:action}" data-id="{:id}" {/ignore} data-button="cancel" class="button">{t 'Winter' 'Restore'}</a>
        </div>
    </div>
</script>
{/if}

<script type="text/javascript">
    window.api = '{url 'winter:api'}';
</script>

{block 'core_js'}
    <script src="{$.assets_public_path('main.js', 'frontend')}"></script>
    <script src="{$.assets_public_path('root.js', 'frontend')}"></script>
{/block}

{render_dependencies_js:raw}
{render_inline_js:raw}
{render_dependencies_css:raw}
{render_inline_css:raw}
{block 'js'}{/block}

</body>
</html>