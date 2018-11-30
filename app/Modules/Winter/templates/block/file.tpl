<div data-editor-item data-name="file">
    {include 'segment/control-pane.tpl'}
    <div class="container files-block">
        <a class="file-area" href="{ignore}{:href}{/ignore}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M6 2c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z"/>
            </svg>
            <span class="name">{ignore}{:name}{/ignore}</span>
        </a>
        {include 'segment/block-controls.tpl'}
    </div>
</div>
