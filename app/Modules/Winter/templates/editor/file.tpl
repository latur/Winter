{add $editable = false}
{add $item = []}
{add $item.data = false}

{if $item.data}
    {set $file = $.file($item.data)}
{/if}

{if $editable}
    <div data-editor-item data-name="file">
        {include 'segment/control-pane.tpl'}
        <div class="container files-block">
            <a class="file-area" {if $item.data}data-code="{$item.data}"{/if} href="{ignore}{:href}{/ignore}" id="{ignore}{:id}{/ignore}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M6 2c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z"/>
                </svg>
                <span class="name">{if $item.data}{$file->name}{else}{ignore}{:name}{/ignore}{/if}</span>
            </a>
            {include 'segment/block-controls.tpl'}
        </div>
    </div>
{else}
    <div class="container files-block">
        <a class="file-area" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M6 2c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z"/>
            </svg>
            <span class="name">{$file->name}</span>
        </a>
    </div>
{/if}
