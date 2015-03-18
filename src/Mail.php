<?php
    namespace Parvus;

    class Mail
    {
        private $mailer, $aConfig, $html;

        public final function __construct()
        {
            /** Read the config */
            $this->aConfig = include(path.'app/config/Mail.php');

            /** New classe mailer */
            $this->mailer = new \PHPMailer();

            /** Define SMTP */
            $this->mailer->isSMTP();
            $this->mailer->isHTML(true);

            $this->mailer->SMTPDebug = 1;

            /** Config the connection with the server */
            $this->mailer->SMTPAuth     = true;
            $this->mailer->Host         = $this->aConfig['host'];
            $this->mailer->Password     = $this->aConfig['password'];
            $this->mailer->Username     = $this->aConfig['user'];
            $this->mailer->Port         = $this->aConfig['port'];
            $this->mailer->CharSet      = 'UTF-8';

            /** TLS ou SSL */
            if ($this->aConfig['SMTPSecure'])
            {
                $this->mailer->SMTPSecure = strToLower($this->aConfig['SMTPSecure']);
            }

            /** From */
            $this->mailer->From     = $this->aConfig['from']['email'];
            $this->mailer->FromName = $this->aConfig['from']['name'];
        }

        /**
         * Add a attachment
         * @param $prFile
         * @param null $prName
         */
        public final function attachment ($prFile,$prName = NULL)
        {
            $this->mailer->addAttachment($prFile,$prName);
        }

        /**
         * Add a BBC
         * @param $prEmail
         */
        public final function bbc ($prMail)
        {
            $this->mailer->addBCC($prMail);
        }

        /**
         * Add a CC
         * @param $prMail
         */
        public final function cc ($prMail)
        {
            $this->mailer->addCC($prMail);
        }

        /**
         * Add a mail address
         * @param $prMail
         */
        public final function address ($prMail)
        {
            if (environment == 'local')
            {
                $prMail = $this->aConfig['mail'];
            }

            $this->mailer->addAddress($prMail);
        }

        /**
         * Define the subject
         * @param $prSubject
         */
        public final function subject ($prSubject)
        {
            $this->mailer->Subject = $prSubject;
        }

        /**
         * Define the mail content
         * @param $prHTML
         */
        public final function body ($prHTML)
        {
            $this->html = $prHTML;
        }

        /**
         * Sent the mail
         */
        public final function sent ()
        {
            $view = new \Parvus\View();

            /** Generate the HTML with Blade */
            $this->mailer->Body = $view->render ($this->aConfig['view'],array (
                'subject' => $this->mailer->Subject,
                'html'    => $this->html
            ));

            if ($this->mailer->send())
            {
                return true;
            } else {
                throw new \RuntimeException('Mailer error: '.$this->mailer->ErrorInfo,E_ERROR);
            }
        }
    }
