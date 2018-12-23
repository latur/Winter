{extends '_layouts/base.tpl'}

{block 'content'}
    <div class="posts-items">
        {foreach $posts as $post}
            <div class="item">
                <a href="{url 'winter:editor' ['id' => $post->id]}"><h2>{$post->title == "" ? 'Untitled' : $post->title}</h2></a>
                <p>Доиндустриальный тип политической культуры означает онтологический христианско-демократический национализм. Политическая социализация, как бы это ни казалось парадоксальным.</p>
            </div>
        {/foreach}
    </div>
{/block}
