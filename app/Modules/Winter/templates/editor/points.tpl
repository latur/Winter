{add $editable = false}
{if $editable}
    <div data-editor-item data-name="points">
        {include 'segment/control-pane.tpl'}
        <div class="container">
            <div class="points-spacer"><i></i><i></i><i></i></div>
            {include 'segment/block-controls.tpl'}
        </div>
    </div>
{else}
    <div class="container">
        <div class="points-spacer"><i></i><i></i><i></i></div>
    </div>
{/if}
