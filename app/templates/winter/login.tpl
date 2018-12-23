{extends '_layouts/base.tpl'}

{block 'body-class'}login-page{/block}

{block 'body'}
    <div class="container login-form-wrapper">
        <div class="logo-wrapper">
            <a class="logo" href="{url 'winter:index'}"><span class="first-letter">W</span>inter</a>
        </div>
        <div class="login-form boxed">
            <form action="" method="post">
                {raw $form->render()}
                <input type="hidden" name="{$.request->csrfTokenName}" value="{$.request->getCsrfToken()}" />
                <div class="buttons">
                    <button type="submit" class="button primary block">
                        {t "Admin.auth" "Log in"}
                    </button>
                </div>
            </form>
        </div>
    </div>
{/block}
