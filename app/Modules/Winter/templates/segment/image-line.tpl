{add $line = []}
{add $line.images = []}
{add $line.type = ""}

<div data-line class="image-line{if count($line.images) == 0} solo{/if}" data-type="{$line.type}">
    <div class="line-wrapper">
        {if count($line.images) > 0}
            {foreach $line.images as $image}
                {include 'segment/image-image.tpl' image=$image}
            {/foreach}
        {else}
            {if $editable}
                {ignore}{:html}{/ignore}
            {/if}
        {/if}
    </div>
</div>
