{add $src = false}
{add $caption = false}
<iframe data-name="youtube" src="{if $src}{$src}{else}https://www.youtube-nocookie.com/embed/{ignore}{:id}{/ignore}{/if}"
        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
<div class="caption" data-clean
     contenteditable="true" data-name="caption"
     data-hepler="Video caption (optional)">{if $caption}{$caption}{/if}</div>
