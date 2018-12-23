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
                            <a data-action="create" class="button primary">Create story</a>
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
                    <a data-action="logout" href="{url 'winter:logout'}" class="link">{t 'Winter' 'Logout'}</a>
                    <a href="{url 'winter:drafts'}" class="link">{t 'Winter' 'Drafts'}</a>
                    <a href="{url 'winter:stat'}" class="link">{t 'Winter' 'Statistics'}</a>
                {else}
                    <a href="{url 'winter:login'}" class="link">{t 'Winter' 'Login'}</a>
                {/if}
            </div>
        </div>
    {/block}
{/block}

<script type="text/javascript">
    window._route = {ignore}{}{/ignore};
    window._route.create = '{url 'winter:create'}';
    window._route.image = '{url 'winter:image'}';
    window._route.file = '{url 'winter:file'}';
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