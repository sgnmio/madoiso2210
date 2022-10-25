<?php if ( $verified ) { ?>
  <div id="va_code" class="va_detail">
    <div class="va_cont">
      <div>
        <h2>2段階認証の利用</h2>

        <form method="POST" action="<?php echo admin_url( 'admin-post.php' ) ?>" name="enable_form">
          <div class="va_use <?php echo $enabled ? 'on' : '' ?>">
            <input type="hidden" name="action" value="<?php echo $enabled ? 'va_disable' : 'va_enable' ?>">
            <a href="#" onclick="document.enable_form.submit();return false;"></a>
            <span><?php echo $enabled ? 'On' : 'Off' ?></span>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } else { ?>
  <h2>ValueAuthの認証設定が正しくありません。WordPressサイト管理者に確認して下さい。</h2>
<?php } ?>
