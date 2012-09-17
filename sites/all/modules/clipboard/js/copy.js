(function($) {
    $(document).ready(function(){
        //alert($('div#to-copy').text());
        //var str = $("div#to-copy").html().replace(/\<br\>/g, "\r\n").replace(/\<br \/\>/g, "\r\n");
        
        var str = htmlDecodeWithLineBreaks($('div#to-copy pre').html());
        
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
    
    function htmlDecodeWithLineBreaks(html) {
        var breakToken = '_______break_______',
        lineBreakedHtml = html.replace(/<br\s?\/?>/gi, breakToken).replace(/<p\.*?>(.*?)<\/p>/gi, breakToken + '$1' + breakToken);
        return $('<div>').html(lineBreakedHtml).text().replace(new RegExp(breakToken, 'g'), '\r\n');
    }
    
})(jQuery);

