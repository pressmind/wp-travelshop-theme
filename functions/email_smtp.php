<?php
/**
 * Enable SMTP auth support,
 * constants are defined in config-theme.php
 */
if (TS_SMTP_ACTIVE === true) {
    add_action('phpmailer_init', function ($phpmailer) {
        /**
         * @var PHPMailer $phpmailer
         */
        $phpmailer->isSMTP();
        $phpmailer->Host = TS_SMTP_HOST;
        $phpmailer->SMTPAuth = TS_SMTP_AUTH;
        $phpmailer->Port = TS_SMTP_PORT;
        $phpmailer->Username = TS_SMTP_USER;
        $phpmailer->Password = TS_SMTP_PASS;
        $phpmailer->SMTPSecure = TS_SMTP_SECURE;
        $phpmailer->From = TS_SMTP_FROM_EMAIL;
        $phpmailer->FromName = TS_SMTP_FROM_NAME;
    });
}
