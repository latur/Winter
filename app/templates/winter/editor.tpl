{extends '_layouts/base.tpl'}

{block 'page'}
    <div class="container meta post-title">
        <h1 contenteditable="true" data-clean data-name="post-title" data-hepler="Post title">{$post->title}</h1>
    </div>

    {set $editable = true}

    <div class="post-style" data-editable>
        {raw $post->getContent($editable)}
    </div>

    {include 'segment/control-pane.tpl'}

    <div data-meta class="modal">
        <div class="container">
            <div class="modal-box boxed">
                <label>
                    <span class="label">{t 'Winter' 'Title'}</span>
                    <input type="text" class="form-control" value="" placeholder="" />
                </label>
                <label>
                    <span class="label">{t 'Winter' 'Slug'}
                        <span class="slug-helper">{$.server.HTTP_HOST}/<span data-sync="slug"></span></span>
                    </span>
                    <input type="text" class="form-control" value="" data-sync="slug" placeholder="" />
                </label>
                <label>
                    <span class="label">{t 'Winter' 'Introduction'}</span>
                    <textarea class="form-control"></textarea>
                </label>
                <button class="button primary block">{t 'Winter' 'Save & Publish'}</button>
            </div>
        </div>
    </div>


    <script type="text/template" id="file">
        <input type="file" name="uploader" multiple />
    </script>
    <script type="text/template" id="file-block">
        {include 'editor/file.tpl'}
    </script>


    <script type="text/template" id="video">
        {include 'editor/video.tpl'}
    </script>
    <script type="text/template" id="video-youtube">
        {include 'segment/video-youtube.tpl'}
    </script>
    <script type="text/template" id="video-vimeo">
        {include 'segment/video-vimeo.tpl'}
    </script>


    <script type="text/template" id="text">
        {include 'editor/text.tpl'}
    </script>


    <script type="text/template" id="image">
        <input accept="image/*" type="file" name="uploader" multiple />
    </script>
    <script type="text/template" id="image-block">
        {include 'editor/image.tpl'}
    </script>
    <script type="text/template" id="image-line">
        {include 'segment/image-line.tpl'}
    </script>
    <script type="text/template" id="image-image">
        {include 'segment/image-image.tpl'}
    </script>


    <script type="text/template" id="points">
        {include 'editor/points.tpl'}
    </script>
{/block}

{block 'controls'}
    <a data-action="save" class="button">Save & Publish</a>
{/block}
