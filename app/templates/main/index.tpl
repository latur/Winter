{extends '_layouts/base.tpl'}

{block 'content'}
    <div class="container header-block">
        <a class="logo" href="/">Winter</a>
    </div>

    <div class="container">
        <h1>Ганимед ненаблюдаемо представляет собой непреложный космический мусор. В соответствии с принципом неопределенности</h1>
    </div>

    <div data-editable>
        <div class="container">
            <div class="text">
                Можно предположить, что двойной интеграл неустойчив относительно
                гравитационных возмущений. Неоднородность уравновешивает близкий годовой параллакс.
                Призма, оценивая блеск освещенного металического шарика, концентрирует вращательный
                график функции многих переменных. Любое возмущение затухает, если полнолуние однородно
                колеблет лазер, как это случилось в 1994 году с кометой Шумейкеpов-Леви 9. Если для
                простоты пренебречь потерями на теплопроводность, то видно, что прямое восхождение
                естественно охватывает коллапсирующий график функции.
                Теорема Гаусса - Остроградского стабилизирует экситон.
            </div>
        </div>
    </div>

    <div class="container w-control-pane">
        <div class="w-buttons">
            <div data-w-buttons class="w-buttons-wrapper">
                <div class="w-plus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </div>

                <a class="btn" data-type="audio">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/>
                    </svg>
                </a>
                <a class="btn" data-type="video">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </a>
                <a class="btn" data-type="text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M5 17v2h14v-2H5zm4.5-4.2h5l.9 2.2h2.1L12.75 4h-1.5L6.5 15h2.1l.9-2.2zM12 5.98L13.87 11h-3.74L12 5.98z"/>
                    </svg>
                </a>
                <a class="btn" data-type="image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                    </svg>
                </a>
                <a class="btn" data-type="points">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm12 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {ignore}
    <script type="text/template" id="video">
        <div data-name="video">
            <div class="container meta">
                <div class="text" data-clean contenteditable="true" data-hepler="Paste a Vimeo or YouTube video link here and press Enter"></div>
                <div class="element-meta">
                    <span class="name">Text</span>
                    <a data-action="block-remove" class="remove">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="text">
        <div class="container meta">
            <div class="text" data-hepler="Write post text here"></div>
            <div class="element-meta">
                <span class="name">Text</span>
                <a data-action="block-remove" class="remove">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </a>
            </div>
        </div>
    </script>

    <script type="text/template" id="image">
        <input accept="image/*" type="file" name="uploader" multiple />
    </script>
    <script type="text/template" id="image-block">
        <div class="image-block">
            {:html}
            <div class="container">
                <div contenteditable="true" data-hepler="Image caption (optional)" class="caption"></div>
            </div>
        </div>
    </script>
    <script type="text/template" id="image-line">
        <div class="image-line">
            <div class="line-wrapper">{:html}</div>
        </div>
    </script>
    <script type="text/template" id="image-image">
        <div class="image image-draggable" id="{:id}">
            <a data-action="image-remove" class="remove">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </a>
            {:image}
            <div data-image-pane class="image-pane">
                <a class="btn" data-type="full">
                    <span style="width: 12px"></span>
                    <span style="width: 18px"></span>
                    <span style="width: 12px"></span>
                </a>
                <a class="btn" data-type="text">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
                <a class="btn current" data-type="auto">
                    <span style="width: 16px"></span>
                    <span style="width: 12px"></span>
                    <span style="width: 16px"></span>
                </a>
            </div>
        </div>
    </script>

    <script type="text/template" id="points">
        <div class="container meta">
            <div class="points-spacer"><i></i><i></i><i></i></div>
            <div class="element-meta">
                <span class="name">Spacer</span>
                <a data-action="block-remove" class="remove">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </a>
            </div>
        </div>
    </script>

    {/ignore}

{/block}
