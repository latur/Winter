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
<body {if $.is_debug}data-debug="debug"{/if}>

<div class="container header-block">
    <a class="logo" href="/">Winter</a>
    <div class="buttons-pane">
        <a data-create class="button">Create story</a>
        <a data-save class="button">Save</a>
    </div>
</div>

{block 'content'}
    content base.tpl
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