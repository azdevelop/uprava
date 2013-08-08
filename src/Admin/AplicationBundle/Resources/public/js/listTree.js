
var listTree = {

    inputHidden: "",

    choose: function( pageInp, page ){

        $('.page').removeClass('active');

        pageInp.val( $(page).data("id") );

        $( page ).addClass( "active" );

        return this;
    },

    currentPage: function(){

        var current = this.inputHidden.val();

        $(".treeList [data-id='"+current+"']").addClass( "active" );

        return this;

    },

    treeSelect: function( inputHidden ){

        var _this = this;

        _this.inputHidden = inputHidden;

        this.currentPage();

        $('.page').click(function(){
            _this.choose(  _this.inputHidden, this );
        });

        return this;
    },

    removeMe: function() {
        // TODO
        alert(1111);
    }

}



