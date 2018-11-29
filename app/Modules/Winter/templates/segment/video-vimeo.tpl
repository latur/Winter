{add $src = false}
{add $caption = false}
<iframe data-name="vimeo"
        src="{if $src}{$src}{else}https://player.vimeo.com/video/{ignore}{:id}{/ignore}{/if}"
        frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<div class="caption" data-clean contenteditable="true"
     data-name="caption"
     data-hepler="Video caption (optional)">{if $caption}{$caption}{else}{ignore}{:caption}{/ignore}{/if}</div>
