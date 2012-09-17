(function($) {
    $(document).ready(function(){
        //alert($('div#to-copy').text());
        var str = $("div#to-copy").html().replace(/\<br\>/g, "\r\n").replace(/\<br \/\>/g, "\r\n");

        $('a.copy-button').zclip({
            path:Drupal.settings.clipboard.swf_path +'/ZeroClipboard.swf',
            beforeCopy:function(){
                $('input#edit-update').click();
            },
            copy: str,
            afterCopy:function(){
                alert("The cart contents has been copied to clipboard.");
            }
        });
    });
})(jQuery);