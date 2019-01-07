{extends '_layouts/base.tpl'}

{block 'content'}
    <div class="posts-items">
        {foreach $posts as $post}
            {include 'parts/post-intro.tpl'}
        {/foreach}
    </div>
{/block}
