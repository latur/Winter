<div class="item" data-post-id="{$post->id}">
    <p class="meta">
        <span class="date">{$post->updated|date}</span> <span class="min">{$post->min_read} {t 'Winter' 'min read'}</span>
    </p>
    <h2 class="title-wrapper">
        <a href="{$post->getUrl()}">{$post->title == "" ? 'Untitled' : $post->title}</a>
        {if $admin}
            <span class="post-actions">
            <a data-action="remove" data-id="{$post->id}" class="button round danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </a>
            <a href="{url 'winter:editor' ['id' => $post->id]}" class="button round">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                </svg>
            </a>
            </span>
        {/if}
    </h2>
    {if $post->introduction != ""}
        <p>{$post->introduction|truncate:140:" ...":true}</p>
    {/if}
</div>
