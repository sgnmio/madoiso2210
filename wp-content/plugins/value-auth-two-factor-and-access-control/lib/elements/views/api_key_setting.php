<link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<div id="va_code" class="va_detail">
    <div class="va_cont">
        <form method="POST" action="<?php echo admin_url( 'admin-post.php' ) ?>">
            <input type="hidden" name="action" value="va_update_api_key">
            <div class="va_key">
                <h2>認証設定</h2>
                <div>
                    <h3>APIキー
						<a href="https://www.value-domain.com/security/value-auth/userguide/api_add.php" target="_blank" data-toggle="tooltip" class="float-lg-right mt-2 mr-2"><i class="fa fa-question-circle fa-1x"></i></a>
					</h3>

                    <textarea name="api_key"><?php echo $apiKey ?></textarea>
                </div>
                <div>
                    <h3>認証コード
						<a href="https://www.value-domain.com/security/value-auth/userguide/setting.php" target="_blank" data-toggle="tooltip" class="float-lg-right mt-2 mr-2"><i class="fa fa-question-circle fa-1x"></i></a>
					</h3>
                    <input type="text" value="<?php echo $authCode ?>" name="auth_code">
                </div>
                <div>
                    <h3>公開鍵
						<a href="https://www.value-domain.com/security/value-auth/userguide/api_add.php#key_create" target="_blank" data-toggle="tooltip" class="float-lg-right mt-2 mr-2"><i class="fa fa-question-circle fa-1x"></i></a>
					</h3>
                    <textarea name="public_key"><?php echo $publicKey ?></textarea>
                </div>
            </div>
            <input type="submit" value="登録">
        </form>

        <section>
            <h3> ご利用前の準備 </h3>
            <ul class="collapse show">
				<li>ValueAuthのご利用には、<a href="https://www.value-domain.com/" target="_blank" class="manual_link">バリュードメイン <i class="fa fa-external-link"></i></a>のアカウントが必要になります。</li>
				<li>アカウントのご準備は<a href="https://www.value-domain.com/security/value-auth/userguide/" target="_blank" class="manual_link"><i class="fa fa-book" aria-hidden="true"></i>マニュアル「Value-Authの申込み方法」 <i class="fa fa-external-link"></i></a>をご確認下さい。</li>
            </ul>
        </section>

    </div>
</div>
