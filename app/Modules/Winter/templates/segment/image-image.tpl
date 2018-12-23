{add $id = "{:id}"}

{if $editable}
    <div class="image image-draggable" id="{$id}">
        <a data-action="image-remove" class="remove">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </a>
        {add $image = "{:image}"}
        {if is_array($image)}
            {img:raw $image.code}
        {else}
            {$image}
        {/if}
        <div data-image-pane class="image-pane">
            <a class="btn" data-type="full">
                <span style="width: 12px"></span>
                <span style="width: 18px"></span>
                <span style="width: 12px"></span>
            </a>
            <a class="btn" data-type="text">
                <span></span>
                <span></span>
                <span></span>
            </a>
            <a class="btn current" data-type="mini">
                <span style="width: 16px"></span>
                <span style="width: 12px"></span>
                <span style="width: 16px"></span>
            </a>
        </div>
    </div>
{else}
    <div class="image">
        {add $image = "{:image}"}
        {if is_array($image)}
            {img:raw $image.code}
        {else}
            {$image}
        {/if}
    </div>
{/if}
