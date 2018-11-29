{add $item.data = []}
{add $item.data.youtube = false}
{add $item.data.vimeo = false}
{add $item.data.caption = ""}

<div data-name="video">
    <div class="container meta video-block">
        {if $item.data.youtube}
            {include 'segment/video-youtube.tpl' src=$item.data.youtube caption=$item.data.caption}
        {elseif $item.data.vimeo}
            {include 'segment/video-vimeo.tpl' src=$item.data.vimeo caption=$item.data.caption}
        {else}
            <div class="text" data-clean contenteditable="true" data-hepler="Paste a Vimeo or YouTube video link here and press Enter"></div>
        {/if}
        {include 'segment/element-meta.tpl' name="Video"}
    </div>
</div>
