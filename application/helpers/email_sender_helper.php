<?php

function send_email($email, $subject, $body, $from = 'ahmed@dominosmedia.com') {

    $CI = & get_instance();
    $CI->load->library('email');

    $mail_config = array(
        'mailtype' => 'html'
    );
    $CI->email->initialize($mail_config);

    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'ahmed@dominosmedia.com',
        'smtp_pass' => 'XCBNM679tr',
        'mailtype' => 'html',
    );

    $CI->email->from($from, 'mapegy');
    $CI->email->to($email);
    $CI->email->reply_to($from, 'mapegy');

    $CI->email->subject($subject);

    $html_email = '<html><head></head><body style="width:600px;background-color: #FFFFFF;font-family: Calibri;">
    <div>        
        </div>
            <div style="margin-top: 20px;margin-bottom: 20px;margin-left: 20px;">
                <div>
                    <p>
                        ' . $body . '
                    </p>
                </div>
                <p style="font-size: 13px; font-style: italic;">Thanks &amp; Best Regards, <br />
                mapegy Team</p>
            </div>
            <div style="width: 600px; height: 30px;">
                <span style="font-size: 11px;color: #404040;padding-left: 200px;padding-top: 2px;
                      display: inline-block; margin-top: 5px;">All rights reserved &copy; mapegy ' . date('Y') . '</span>
            </div>
        </body></html>';

    $CI->email->message($html_email);
    $CI->email->send();
}

?>