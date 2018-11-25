{add $item = []}
{add $item.data = ""}
<div data-name="text">
    <div class="container meta">
        <div data-name="text" class="text" data-hepler="Write post text here">{raw $item.data}</div>
        {include 'parts/element-meta.tpl' name="Text"}
    </div>
</div>
