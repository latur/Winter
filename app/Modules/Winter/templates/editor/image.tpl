{add $editable = false}
{add $item = []}
{add $item.data = []}
{add $item.data.lines = []}

{if $editable}
    <div data-editor-item data-name="image">
        {include 'segment/control-pane.tpl'}
        <div class="image-block">
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
{else}
    <div class="image-block">
        {if count($item.data.lines) > 0}
            {foreach $item.data.lines as $line}
                {include 'segment/image-line.tpl' line=$line}
            {/foreach}
        {/if}
        {if $item.data.helper! && $item.data.helper != ""}
            <div class="container">
                <div class="caption">{$item.data.helper}</div>
            </div>
        {/if}
    </div>
{/if}
