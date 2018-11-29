{add $item = []}
{add $item.data = ""}
<div data-name="text">
    <div class="container meta">
        <div data-name="text" class="text paragraph" data-hepler="Write post text here">{raw $item.data}</div>
        {include 'segment/element-meta.tpl' name="Text"}
    </div>
</div>
