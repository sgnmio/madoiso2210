<?php if ( $verified ) { ?>
  <div id="app"></div>
  <input type="hidden" value="<?php echo $accessToken ?>" id="access_token"/>
  <input type="hidden" value="<?php echo $_SERVER['REQUEST_URI'] ?>" id="base_url"/>
  <input type="hidden" value="<?php echo $apiUrl ?>" id="api_url"/>
<?php } else { ?>
  <h2>ValueAuthの認証設定が正しくありません。WordPressサイト管理者に確認して下さい。</h2>
<?php } ?>
