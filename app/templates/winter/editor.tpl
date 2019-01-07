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
    <a data-action="save" class="button primary disabled">Save & Publish</a>
{/block}
