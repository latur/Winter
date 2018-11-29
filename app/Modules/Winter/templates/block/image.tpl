{add $item = []}
{add $item.data = []}
<div data-editor-item data-name="image">
    {include 'segment/control-pane.tpl'}
    <div class="image-block">
        {add $item.data.lines = []}
        {if count($item.data.lines) > 0}
            {foreach $item.data.lines as $line}
                {include 'segment/image-line.tpl' line=$line}
            {/foreach}
        {else}
            {ignore}{:html}{/ignore}
        {/if}
        <div class="container">
            <div contenteditable="true" data-clean data-hepler="Image caption (optional)" class="caption">{if $item.data.helper! && $item.data.helper != ""}{$item.data.helper}{/if}</div>
        </div>
    </div>
</div>
