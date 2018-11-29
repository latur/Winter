{add $item = []}
{add $item.data = ""}
<div data-editor-item data-name="text">
    {include 'segment/control-pane.tpl'}
    <div class="container">
        <div data-name="text" class="text paragraph" data-hepler="Write post text here">{raw $item.data}</div>
        {include 'segment/block-controls.tpl'}
    </div>
</div>
