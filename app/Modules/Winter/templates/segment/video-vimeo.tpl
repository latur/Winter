{add $src = false}
{add $caption = false}

{if $editable}
    <iframe data-name="vimeo"
            src="{if $src}{$src}{else}https://player.vimeo.com/video/{ignore}{:id}{/ignore}{/if}"
            frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <div class="caption" data-clean contenteditable="true"
         data-name="caption"
         data-hepler="Video caption (optional)">{if $caption}{$caption}{else}{ignore}{:caption}{/ignore}{/if}</div>
{else}
    {if $src}
        <iframe data-name="vimeo" src="{$src}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        {if $caption}
            <div class="caption">{$caption}</div>
        {/if}
    {/if}
{/if}
