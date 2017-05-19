<?php

require_once('FileManagerHelper.php');

?>
    <style><? include 'file_manager.css';?></style>

    <div class="tab">
        <button class="tablinks" onclick="open_tab(event, 'upload_tab_content')" id="upload_tab">Upload Images</button>
        <button class="tablinks" onclick="open_tab(event, 'browse_tab_content')" id="browse_tab">Browse Images</button>
    </div>

    <div id="upload_tab_content" class="tabcontent">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>

    <div id="browse_tab_content" class="tabcontent file_manager_thumbs_container">
        <div>
            <?
            foreach (scandir(FileManagerHelper::$server_dir.'thumbs') as $filename) {
                if ((new FileManagerHelper($filename))->file_type_allowed()) {
                    ?>
                    <div class='file_manager_img_thumb'>
                        <img src='serve_image.php?thumb=1&filename=<?=$filename?>' onclick="select_image(event, '<?=$filename?>')">
                        <div><?=$filename?></div>
                    </div>
                    <?
                }
            }
            ?>
        </div>
    </div>

<script>
    <?if ($_SESSION['flashdata']['file_manager_alert']) {?>
        document.getElementById('browse_tab').click();
        alert("<?=$_SESSION['flashdata']['file_manager_alert']?>");
        <?
        unset($_SESSION['flashdata']['file_manager_alert']);
    } else {
        echo "document.getElementById('upload_tab').click();";
    }?>
    function open_tab(evt, cityName)
    {
        var i, tabcontent, tablinks;
        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function select_image(e, filename)
    {
        var content_to_insert = "<img src='<?=str_replace('file_manager.php', 'serve_image.php', $_SERVER['REQUEST_URI'])?>?thumb=0&filename=" + filename + "' width='400'>";
        top.tinymce.activeEditor.execCommand("mceInsertContent", false, content_to_insert);
        top.tinymce.activeEditor.windowManager.close();
    }

    function delete_image()
    {

    }
</script>