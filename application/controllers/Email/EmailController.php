<?php use PhpImap\Exceptions\ConnectionException;

if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 */
class EmailController extends BaseController
{

    protected $mailbox;
    protected $mailsIds;
    protected $username;
    protected $password;

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();                             // Enable SMTP authentication
        $this->username   = 'admin1@combrinck.co.za';               // SMTP username
        $this->password   = 'aTest1234@01';

        $this->load->helper('download');
        $this->email = new PhpMailer\PHPMailer(true);
        $this->email->isSMTP();                                            // Set mailer to use SMTP
        $this->email->Host       = 'cp13.domains.co.za';                   // Specify main and backup SMTP servers
        $this->email->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->email->Username   = $this->username;               // SMTP username
        $this->email->Password   = $this->password;                         // SMTP password
        $this->email->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $this->email->Port       = 465;                                    // TCP port to connect to

        $this->isLoggedIn();
    }
    /**
     * This function is used to size convert to formated string
     */
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        elseif ($bytes >= 1048576)
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        elseif ($bytes >= 1024)
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        elseif ($bytes > 1)
            $bytes = $bytes . ' bytes';
        elseif ($bytes == 1)
            $bytes = $bytes . ' byte';
        else
            $bytes = '0 bytes';
        return $bytes;
    }
    function folderListing()
    {
        $box_name_no = $this->input->get('boxname');
        if ($box_name_no == "") die('IMAP connection failed');
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}INBOX.'
            .(strtolower($box_name_no)=="junk"?"spam":$box_name_no), $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        try {
            $this->mailsIds = $this->mailbox->searchMailbox('ALL');
        } catch(PhpImap\Exceptions\ConnectionException $ex) {
            echo "IMAP connection failed: " . $ex;
            die();
        }
//        var_dump($this->mailsIds);exit;
        $box_name = strtolower($box_name_no);
        $mails = $this->mailbox->getMailsInfo($this->mailsIds);
        $records = [];
        for ($i=0; $i < sizeof($mails); $i++) {
            $oneMail = $mails[$i];
            $record = [];
            $record['subject'] = $oneMail->subject;
            $record['from'] = $oneMail->from;
            $record['to'] = $oneMail->to;
            $date = new DateTime($oneMail->date);
            if ($date->format('Y-m-d') == date('Y-m-d'))
                $date = "Today ".$date->format('H:i');
            else
                $date = $date->format('Y-m-d H:i');
            $record['date'] = $date;
            $record['message_id'] = $oneMail->message_id;
            $record['size'] = $this->formatSizeUnits($oneMail->size);
            $record['uid'] = $oneMail->uid;
            $record['msgno'] = $oneMail->msgno;
            $record['recent'] = $oneMail->recent;
            $record['flagged'] = $oneMail->flagged;
            $record['answered'] = $oneMail->answered;
            $record['deleted'] = $oneMail->deleted;
            $record['seen'] = $oneMail->seen;
            $record['draft'] = $oneMail->draft;
            $record['udate'] = $oneMail->udate;
            if($this->mailbox->getMail($this->mailsIds[$i])->hasAttachments()) {
                $record['attachment'] = 1;
            } else {
                $record['attachment'] = 0;
            };
            array_push($records, $record);
        }
        $this->global['pageTitle'] = 'E-mail : '.$box_name_no;
        $data['records'] = $records;
        $data['box_name'] = $box_name;
        $data['box_name_no'] = $box_name_no;
        $this->loadViews("email/folders", $this->global, $data);
    }
    /**
     * This function is used to load the inbox list
     */
    function inboxListing()
    {
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}INBOX', $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        try {
            $this->mailsIds = $this->mailbox->searchMailbox('ALL');
        } catch(PhpImap\Exceptions\ConnectionException $ex) {
            echo "IMAP connection failed: " . $ex;
            die();
        }
        $mails = $this->mailbox->getMailsInfo($this->mailsIds);
        $records = [];
        for ($i=0; $i < sizeof($mails); $i++) {
            $oneMail = $mails[$i];
            $record = [];
            $record['subject'] = $oneMail->subject;
            $record['from'] = $oneMail->from;
            $record['to'] = $oneMail->to;
            $date = new DateTime($oneMail->date);
            if ($date->format('Y-m-d') == date('Y-m-d'))
                $date = "Today ".$date->format('H:i');
            else
                $date = $date->format('Y-m-d H:i');
            $record['date'] = $date;
            $record['message_id'] = $oneMail->message_id;
            $record['size'] = $this->formatSizeUnits($oneMail->size);
            $record['uid'] = $oneMail->uid;
            $record['msgno'] = $oneMail->msgno;
            $record['recent'] = $oneMail->recent;
            $record['flagged'] = $oneMail->flagged;
            $record['answered'] = $oneMail->answered;
            $record['deleted'] = $oneMail->deleted;
            $record['seen'] = $oneMail->seen;
            $record['draft'] = $oneMail->draft;
            $record['udate'] = $oneMail->udate;
            if($this->mailbox->getMail($this->mailsIds[$i])->hasAttachments()) {
                $record['attachment'] = 1;
            } else {
                $record['attachment'] = 0;
            }
            array_push($records, $record);
        }
        $this->global['pageTitle'] = 'E-mail : Inbox';
        $data['records'] = $records;
        $this->loadViews("email/inbox", $this->global, $data);
    }
    function getContent(){
        $mail_id = $this->input->get('mail_id');
        $mail_box = $this->input->get('mail_box');
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}'
            .(strtolower($mail_box)=="inbox.junk"?"INBOX.spam":$mail_box), $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        try {
            $this->mailsIds = $this->mailbox->searchMailbox('ALL');
        } catch(PhpImap\Exceptions\ConnectionException $ex) {
            echo "IMAP connection failed: " . $ex;
            die();
        }

        if (intval($mail_id) == 0)
        {
            die("");return;
        }
        $mail = $this->mailbox->getMail($mail_id);
        echo ($mail->textHtml==""?"<HTML><BODY><pre>".$mail->textPlain."</pre></BODY></HTML>":$mail->textHtml);
        exit;
    }
    function getHeader(){
        $mail_id = $this->input->get('mail_id');
        $mail_box = $this->input->get('mail_box');
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}'.(strtolower($mail_box)=="inbox.junk"?"INBOX.spam":$mail_box), $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        if (intval($mail_id) == 0)
        {
            die("");return;
        }
        $mail = $this->mailbox->getMailHeader($mail_id);
        echo json_encode($mail);
    }
    function getAttachment(){
        $mail_id = $this->input->get('mail_id');
        $mail_box = $this->input->get('mail_box');
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}'.(strtolower($mail_box)=="inbox.junk"?"INBOX.spam":$mail_box), $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        if (intval($mail_id) == 0)
        {
            die("");return;
        }
        $mail = $this->mailbox->getMail($mail_id);
        if($mail->hasAttachments()) {
            $attachment = $mail->getAttachments();
            echo json_encode($attachment);
        } else {
            echo "No";
        }
    }
    function download() {
        $fileName = $this->input->get('filename');
        if ($fileName) {
            $arrFile = explode('_', $fileName);
            $realname = $arrFile[sizeof($arrFile) - 1];
            $file = $fileName;//realpath ( "download" ) . "\\" . $fileName;
            // check file exists
            if (file_exists ( $file )) {
                // get file content
                $data = file_get_contents ( $file );
                //force download
                force_download ( $realname, $data );
            } else {
                // Redirect to base url
                redirect ( base_url () );
            }
        }
    }

    /**
     * This function is used to make new message
     */
    function compose()
    {
        $this->global['pageTitle'] = 'E-mail : New Message';
        $data['from'] = $this->username;
        $data['to'] = '';
        $data['textHtml'] = '';
        $this->loadViews("email/compose", $this->global, $data);
    }

    /**
     * This function is used to reply about exist mail
     */
    function reply()
    {
        $mail_id = $this->input->get('mail_id');
        $box_name_no = $this->input->get('boxname');
        if ($box_name_no == "") die('IMAP connection failed');
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}'.(strtolower($box_name_no)=="inbox.junk"?"INBOX.spam":$box_name_no), $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        $mail = $this->mailbox->getMail($mail_id);
        $html_base = $mail->textPlain==""?$mail->textHtml:"<HTML><BODY><pre>".$mail->textPlain."</pre></BODY></HTML>";
        $mail_header = $this->mailbox->getMailHeader($mail_id);

        $this->global['pageTitle'] = 'E-mail : Reply';
        $data['user_name'] = $this->username;
        $data['mail_info'] = $mail_header;
        $data['mail_content'] = $html_base;
        $data['mail_attachment'] = array();
        if($mail->hasAttachments()) {
            $attachment = $mail->getAttachments();
            $data['mail_attachment'] = $attachment;
        }
        $data['page_name'] = 'Reply';
        $this->loadViews("email/reply_forward", $this->global, $data);
    }

    /**
     * This function is used to forward exist mail
     */
    function forward()
    {
        $this->global['pageTitle'] = 'E-mail : Forward';
        $mail_id = $this->input->get('mail_id');
        $box_name_no = $this->input->get('boxname');
        if ($box_name_no == "") die('IMAP connection failed');
        $this->mailbox = new PhpImap\Mailbox('{cp13.domains.co.za:993/imap/ssl}'.(strtolower($box_name_no)=="inbox.junk"?"INBOX.spam":$box_name_no), $this->username, $this->password
            , __DIR__.DIRECTORY_SEPARATOR.'loadtemp', 'UTF-8');
        $mail = $this->mailbox->getMail($mail_id);
        $html = $mail->textHtml==""?"<HTML><BODY><pre>".$mail->textPlain."</pre></BODY></HTML>":$mail->textHtml;
        $mail_header = $this->mailbox->getMailHeader($mail_id);

        $data['user_name'] = $this->username;
        $data['mail_info'] = $mail_header;
        $data['mail_content'] = $html;
        $data['mail_attachment'] = array();
        if($mail->hasAttachments()) {
            $attachment = $mail->getAttachments();
            $data['mail_attachment'] = $attachment;
        }
        $data['page_name'] = 'Forward';
        $this->loadViews("email/reply_forward", $this->global, $data);
    }

    /**
     * This function is used to send the mail and save to sent folder
     */
    function sendMail(){
        $dir = __DIR__.DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
        ini_set('memory_limit','256M');
        $attachments = array();
        if (isset($_FILES) && !empty($_FILES)) {
            $files = $_FILES;
            foreach ($files as $file)
            {
                if ($file['size'] / 1048576 > 5) continue;
                $fileTmpPath = $file['tmp_name'];
                $fileName = $file['name'];
                $dest_path = $dir . $fileName;
                if(move_uploaded_file($fileTmpPath, $dest_path))
                {
                    array_push($attachments, $dest_path);
                }
            }
        }
        $exist_attach = $this->input->post('exist_ids');
        $exist_attach_names = $this->input->post('exist_names');
        $exist_array = explode("#@#", $exist_attach);
        $exist_names_array = explode("#@#", $exist_attach_names);
        $exist_file_match = array();
        $i = -1;
        foreach ($exist_array as $exist)
        {
            ++$i;
            if ($exist == "") continue;
            $exist_file_match[$exist] = $exist_names_array[$i];
            array_push($attachments, $exist);
        }
        $this->email->SetFrom($this->username, 'Your Name'); //Name is optional
        $this->email->addAddress($this->input->post('to'), "");//to_mail, to_name
        $this->email->isHTML(true);
        $this->email->Subject = $this->input->post('subject');
        $this->email->Body = $this->input->post('message');
        if (sizeof($attachments) > 0)
        {
            foreach ($attachments as $attach) {
                if (array_key_exists($attach, $exist_file_match)) {
                    $this->email->addAttachment($attach, $exist_file_match[$attach]);
                }else{
                    $this->email->addAttachment($attach);
                }
            }
        }
        if($this->email->send())
        {
            $this->save_mail_sent($this->email);
            foreach ($attachments as $attach)
                unlink($attach);
            echo 'yes';
        }
        else
        {
            echo $this->email->print_debugger();
        }
        exit;
    }

    /**
     * This function is used to save in sent folder after send the mail
     */
    function save_mail_sent($mail) {
        $path = "{cp13.domains.co.za:993/imap/ssl}INBOX.Sent";
        $imapStream = imap_open($path, $mail->Username, $mail->Password);
        $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);
        return $result;
    }
    
}
?>
