<?php
    namespace Parvus;

    class Mail
    {
        private $mailer, $aConfig, $html;
        private $withLog = false;

        public final function __construct()
        {
            /** Read the config */
            $this->aConfig = include(path.'app/config/Mail.php');

            /** New classe mailer */
            $this->mailer = new \PHPMailer();

            /** Define SMTP */
            $this->mailer->isSMTP();
            $this->mailer->isHTML(true);

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
                $this->mailer->SMTPSecure = mb_strtolower($this->aConfig['SMTPSecure'],'UTF-8');
            }

            /** From */
            $this->mailer->From     = $this->aConfig['from']['email'];
            $this->mailer->FromName = $this->aConfig['from']['name'];
        }

        /**
         * Add a reply to
         * @param $prMail
         * @param $prName
         */
        public final function replyTo ($prMail, $prName = NULL)
        {

            $this->mailer->addReplyTo($prMail,$prName);

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
         * Add a attachment as string
         * @param string $prFile
         * @param null $prName
         */
        public final function attachmentString ($prFile,$prName = NULL)
        {
            $this->mailer->addStringAttachment($prFile,$prName);
        }

        /**
         * Add a BBC
         * @param $prMail
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
         * @param $prName
         */
        public final function address ($prMail,$prName = NULL)
        {
            $this->mailer->addAddress($prMail,$prName);
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
         * Define show log, not sending the mail
         */
        public final function withLog ()
        {
            
            $this->withLog = true;
            
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

            /** If has logging */
            if ($this->withLog)
            {
                
                print('<pre>');
                    print_r($this->mailer);
                print('</pre>');

                return true;
            }

            /** If has local, return true **/
            if (environment == 'local')
            {
                return true;
            }

            if ($this->mailer->send())
            {
                return true;
            } else {
                throw new \RuntimeException('Mailer error: '.$this->mailer->ErrorInfo,E_ERROR);
            }
        }
    }
