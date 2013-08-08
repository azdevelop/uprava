$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
                output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };


    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
                action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable').nestable({'maxDepth':3});


    $('#admin_navmenubundle_navmenutype_type').select(function() {
        alert('Handler for .select() called.');
    });


    var NavMenuType = {

        chooseType :  function() {

            if( $('#admin_navmenubundle_navmenutype_type').val() == 'page'){
                $('.page_container').show();
                $('.url_container').hide();
            }
            else {
                $('.url_container').show();
                $('.page_container').hide();
            }
        }

    }

    NavMenuType.chooseType();

    $('#admin_navmenubundle_navmenutype_type').click(function(){
        NavMenuType.chooseType();
    });


    listTree.treeSelect( $("#admin_navmenubundle_navmenutype_pageId"));

});



$('#saveNMTree').click(function(){

    var tree = $('.dd').nestable('serialize');

    var url=$("#navArange").attr("action");

    $.post( url,
            { "nav_tree": tree },
            function(data){
            console.log(data);
    });

});
