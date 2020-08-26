<?php
$menu_open = '';
$display = '';
if ($this->uri->segment(1) == "email")
{
    $menu_open = 'menu-open';
    $display = 'display:block';
}

?>
<li class="treeview <?=$menu_open?>">
  <a href="#">
    <i class="fa fa-envelope"></i> <span>E-Mail</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      <span class="label label-rouded label-warning pull-right">3</span>
    </span>

  </a>
  <ul class="treeview-menu" style=" <?=$display?>">
    <li class=""><a href="<?php echo base_url() ?>email/inboxListing"><i class="fa fa-inbox"></i>Inbox</a></li>
    <?php
        sort($mail_list);
        foreach ($mail_list as $mail)
        {
            $mail_array = explode("INBOX", $mail);
            $box_name = $mail_array[1];
            $icon = '';
            $box_name = str_replace('.', '', $box_name);
            $box_name_no = $box_name;
            if (strtolower($box_name) == "archive") $icon = 'fa-archive';
            else if (strtolower($box_name) == "spam") continue;
            else if (strtolower($box_name) == "drafts") $icon = 'fa-pencil';
            else if (strtolower($box_name) == "sent") $icon = 'fa-envelope-o';
            else if (strtolower($box_name) == "junk") $icon = 'fa-ban';
            else if (strtolower($box_name) == "trash") $icon = 'fa-trash-o';
            else $icon = 'fa-folder-o';
            if(strlen($box_name) > 25)
                $box_name = substr($box_name, 0, 20)."..";
            ?>
            <li><a href="<?php echo base_url() ?>email/folderListing?boxname=<?php echo $box_name_no;?>"><i class="fa <?php echo $icon;?>"></i><?php echo $box_name;?></a></li>
            <?php
        }
    ?>
  </ul>
</li>
