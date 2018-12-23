{extends '_layouts/base.tpl'}

{block 'content'}
    <div class="posts-items">
        {foreach $posts as $post}
            <div class="item">
                <p class="date">{$post->created|date}</p>
                <a href="{url 'winter:post' ['slug' => $post->slug]}"><h2>{$post->title == "" ? 'Untitled' : $post->title}</h2></a>
                <p>Доиндустриальный тип политической культуры означает онтологический христианско-демократический национализм. Политическая социализация, как бы это ни казалось парадоксальным.</p>
            </div>
        {/foreach}
    </div>
{/block}
