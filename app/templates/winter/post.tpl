{extends '_layouts/base.tpl'}

{block 'page'}
    <div class="container meta post-title">
        <h1>{$post->title}</h1>
    </div>

    <div class="post-style">
        {raw $post->getContent()}
    </div>
{/block}

{block 'controls'}
    {if $admin}
        <a href="{url 'winter:editor' ['id' => $post->id]}" class="button">{t 'Winter' 'Edit'}</a>
    {/if}
{/block}
