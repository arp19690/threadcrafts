{literal}
    <script>
        $(document).ready(function() {
            $("form[name='checkout_form']").addClass("cm-ajax");
            $("form[name='checkout_form']").addClass("cm-ajax-full-render");
            
            $(".ty-value-changer__increase").click(function() {
                setTimeout(function () { $('#button_cart').click(); }, 1000);
            });
            $(".ty-value-changer__decrease").click(function() {
                setTimeout(function () { $('#button_cart').click(); }, 1000);
            });
            $(".cm-amount").bind('keyup', function(e) {
                setTimeout(function () { $('#button_cart').click(); }, 1000);
            });
        });
        $(document).ajaxComplete(function(event,request, settings) {
            $("form[name='checkout_form']").addClass("cm-ajax");
            $("form[name='checkout_form']").addClass("cm-ajax-full-render");
            
            $(".ty-value-changer__increase").click(function() {
                setTimeout(function () { $('#button_cart').click(); }, 1000);
            });
            $(".ty-value-changer__decrease").click(function() {
                setTimeout(function () { $('#button_cart').click(); }, 1000);
            });
            $(".cm-amount").bind('keyup', function(e) {
                setTimeout(function () { $('#button_cart').click(); }, 1000);
            });
            var url = settings.url;
            if (url.indexOf("products.options") >= 0) {
                $('#button_cart').click();
            }
        }); 
    </script>
{/literal}
