<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    {block 'seo'}{render_meta:raw}{/block}
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{$.assets_public_path('main.css', 'frontend')}">
    <link rel="stylesheet" href="{$.assets_public_path('root.css', 'frontend')}">
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/styles/default.min.css">
    {block 'head'}{/block}
</head>
<body {if $.is_debug}data-debug="debug"{/if}>

{block 'content'}
    content base.tpl
{/block}

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