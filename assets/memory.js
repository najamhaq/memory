/**
 * Created by Najam.Haque on 9/14/14.
 */
var flipBackTimeInMilliSecond = 1500 ; // in ms
function flip(row,col)
{
    jQuery.ajax({
        url: "/click",
        type: "POST",
        data:{ i: row, j: col },
        dataType: "json",
        success : function(result){
            switch (result.match)
            {
            case 'first':
                jQuery('#cell-'+result.row +'-' +result.col).html(result.render);
                console.log('result.render');
                break ;

            case 'true':
                jQuery('#cell-'+result.row +'-' +result.col).html(result.render);
                console.log('result.render');
                break ;

            case 'false':
                // set timer to revert back
                var revert = jQuery('#cell-'+result.row +'-' +result.col).html();
                setTimeout(function(){
                var first_html = "<a href=\"#\" onclick=\"flip("+ result.visible_x+", "+result.visible_y+"); \">" + result.first_render + "</a>";
                jQuery('#cell-'+result.visible_x +'-' +result.visible_y).html(first_html);
                jQuery('#cell-'+result.row +'-' +result.col).html(revert);
                },flipBackTimeInMilliSecond);
                jQuery('#cell-'+result.row +'-' +result.col).html(result.render);
                break ;
           }
        },
        error : function(message){
                alert(message);
        }
   });
}
