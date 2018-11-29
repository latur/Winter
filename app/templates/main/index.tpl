{extends '_layouts/base.tpl'}

{block 'content'}
    <div class="container header-block">
        <a class="logo" href="/">Winter</a>
        <a data-save class="button">Save</a>
    </div>

    <div class="container meta post-title">
        <h1 contenteditable="true" data-clean data-name="post-title" data-hepler="Post title">{$post->title}</h1>
        <div class="element-meta">
            <span class="name">Title</span>
        </div>
    </div>

    <div data-editable>
        {raw $post->getContent()}
    </div>

    {include 'segment/control-pane.tpl'}

    <script type="text/template" id="file">
        <input type="file" name="uploader" multiple />
    </script>
    <script type="text/template" id="file">
        {include 'block/file.tpl'}
    </script>


    <script type="text/template" id="video">
        {include 'block/video.tpl'}
    </script>
    <script type="text/template" id="video-youtube">
        {include 'segment/video-youtube.tpl'}
    </script>
    <script type="text/template" id="video-vimeo">
        {include 'segment/video-vimeo.tpl'}
    </script>


    <script type="text/template" id="text">
        {include 'block/text.tpl'}
    </script>


    <script type="text/template" id="image">
        <input accept="image/*" type="file" name="uploader" multiple />
    </script>
    <script type="text/template" id="image-block">
        {include 'block/image.tpl'}
    </script>
    <script type="text/template" id="image-line">
        {include 'segment/image-line.tpl'}
    </script>
    <script type="text/template" id="image-image">
        {include 'segment/image-image.tpl'}
    </script>


    <script type="text/template" id="points">
        {include 'block/points.tpl'}
    </script>

{/block}
